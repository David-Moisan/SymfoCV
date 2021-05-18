<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Projet $projets, ProjetRepository $repo): Response
    {
        $projets = $this->repo->findAll();

        return $this->render('home/index.html.twig', compact('projets'));
    }
}
