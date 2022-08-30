<?php

namespace App\Controller;

use Exception;
use App\Entity\Program;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityNotFoundException;
use function PHPUnit\Framework\throwException;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('', name: 'app_index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);
    }

    #[Route("/{id<^[0-9]+$>}", name: "show")]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy([
            'id' => $id,
        ]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }
}
