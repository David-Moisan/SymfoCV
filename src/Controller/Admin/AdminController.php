<?php

namespace App\Controller\Admin;

use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $repo;
    private $em;

    public function __construct(ProjetRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /*=================================================================================*/

    /**
     * Index.
     *
     * @Route("/admin", name="admin.index")
     *
     * @return Response
     */
    public function index(): Response
    {
        $projets = $this->repo->findAll();

        return $this->render('/admin/index.html.twig', compact('projets'));
    }

    /*=================================================================================*/

    public function new()
    {
        // code...
    }

    /*=================================================================================*/

    public function edit()
    {
        // code...
    }

    /*=================================================================================*/

    public function delete()
    {
        // code...
    }
}
