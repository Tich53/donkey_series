<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
