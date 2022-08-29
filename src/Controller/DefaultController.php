<?php

namespace App\Controller;

use Exception;
use Doctrine\ORM\EntityNotFoundException;
use function PHPUnit\Framework\throwException;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: 'program_')]
class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('program/index.html.twig', []);
    }

    #[Route('/{id<\d+>}', methods: ["GET"], name: 'app_index')]
    public function show(int $id): Response
    {
        return $this->render('program/show.html.twig', [
            'id' => $id
        ]);
    }
}
