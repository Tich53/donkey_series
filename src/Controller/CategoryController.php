<?php

namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// Don't forget the Request use !!
use Symfony\Component\HttpFoundation\Request;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        if (!$categories) {
            throw $this->createNotFoundException('Aucune catégorie à afficher');
        } else {
            return $this->render('category/index.html.twig', [
                'categories' => $categories,
            ]);
        }
    }

    #[Route("/new", name: "new")]
    public function new(Request $request, ManagerRegistry $managerRegistry): Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $managerRegistry->getManager();
            // Persist Category Object
            $entityManager->persist($category);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('category_index');
        }
        // Render the form
        return $this->render('category/new.html.twig', ["form" => $form->createView()]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(CategoryRepository $categoryRepository, ProgramRepository $programRepository, string $categoryName,): Response
    {
        $category = $categoryRepository->findOneBy([
            'name' => $categoryName,
        ]);

        if (!$category) {
            throw $this->createNotFoundException("Cette catégorie n'existe pas");
        } else {
            $programs = $programRepository->findBy(
                ['category' => $category->getId()],
                ['id' => 'DESC'],
                3,
            );
        }
        if (!$programs) {
            throw $this->createNotFoundException("Aucune série trouvée");
        } else {
            return $this->render('category/show.html.twig', [
                'programs' => $programs,
                'categoryName' => $categoryName,
            ]);
        }
    }
}
