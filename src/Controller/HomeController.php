<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(ProjetRepository $repo)
    {
        $this->repo = $repo;
    }

    private $repo;

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $projets = $this->repo->findAll();

        return $this->render('home/index.html.twig', [
            'projets' => $projets,
        ]);
    }
}
