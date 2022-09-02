<?php

namespace App\Controller;


use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/new', name: 'new_')]
    public function new(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $managerRegistry->getManager();
            // Persist Category Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('program_app_index');
        }
        return $this->render('program/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    #[Route("/{id<^[0-9]+$>}", name: "show")]
    public function show(Program $program, SeasonRepository $seasonRepository): Response
    {

        $seasons = $seasonRepository->findBy([
            'program' => $program->getId()
        ]);


        if (!$program) {
            throw $this->createNotFoundException(
                'No program with this id found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
        ]);
    }

    #[Route("/{program}/seasons/{season}", name: "season_show")]
    public function showSeason(Program $program, Season $season, EpisodeRepository $episodeRepository): Response
    {

        $episodes = $episodeRepository->findBy([
            'season_id' => $season->getId(),
        ]);


        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,

        ]);
    }

    #[Route("/{program}/seasons/{season}/episode/{episode}", name: "episode_show")]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,

            /*             dd($program, $season, $episode), */

        ]);
    }
}

/* Crée une méthode showEpisode(Program $program, Season $season, Episode $episode)

    La route de cette méthode sera donc de la forme /program/{programId}/season/{seasonId}/episode/{episodeId} et le nom de la route sera program_episode_show
    Récupère les objets Program, Season et Episode directement depuis les paramètres de la méthode grâce au param converter
    Cette méthode retournera une nouvelle vue : templates/program/episode_show.html.twig.
    Cette vue affichera :
        le nom de la série
        le numéro de la saison
        le numéro et le titre de l’épisode
        le résumé de l’épisode */