<?php

namespace App\Controller;

use Exception;
use App\Entity\Program;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
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
    public function show(int $id, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
    {
        $program = $programRepository->findOneBy([
            'id' => $id,
        ]);


        $seasons = $seasonRepository->findBy([
            'program' => $program->getId()
        ]);


        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    #[Route("/{programId<\d+>}/seasons/{seasonId<\d+>}", name: "season_show")]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, EpisodeRepository $episodeRepository, SeasonRepository $seasonRepository): Response
    {
        // Demandé dans le challenge mais inutile car infos déjà présente dans la variable $season en dessous
        $program = $programRepository->findOneBy([
            'id' => $programId,
        ]);

        $season = $seasonRepository->findOneBy([
            'id' => $seasonId,
        ]);


        $episodes = $episodeRepository->findBy([
            'season_id' => $season->getId(),
        ]);


        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,

        ]);
    }
}
