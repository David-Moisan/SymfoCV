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
    public function index(Projet $projet, ProjetRepository $repository): Response
    {
        $projets = $this->repository->findAll();
        return $this->render('home/index.html.twig',[
            'projets'=>$projets,
        ]);
    }
}
