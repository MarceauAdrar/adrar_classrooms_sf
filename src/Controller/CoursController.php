<?php

namespace App\Controller;

use App\Repository\ChapitresRepository;
use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cours')]
class CoursController extends AbstractController
{
    #[Route('/', name: 'app_cours')]
    public function index(CoursRepository $coursRepository): Response
    {
        $cours = $coursRepository->findAll();

        return $this->render('cours/index.html.twig', [
            'cours' => $cours,
        ]);
    }
    
    #[Route('/{nom}', name: 'app_cours_nom')]
    public function cours(string $nom, CoursRepository $coursRepository, ChapitresRepository $chapitresRepository): Response
    {
        $cours = $coursRepository->findOneBy(['titre' => ucfirst(str_replace("-", " ", $nom))]);
        $chapitres = $chapitresRepository->findBy(['cours' => $cours->getId()]);

        return $this->render('cours/cours.html.twig', [
            'cours' => $cours,
            'chapitres' => $chapitres,
        ]);
    }
}
