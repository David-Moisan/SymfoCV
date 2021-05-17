<?php
namespace App\Controller\Admin;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProjetController extends AbstractController {
  
    private $repo;
    private $em;

    public function __construct(ProjetRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
    *@Route("/admin/index", name="admin.projet.index")
    * 
    */

    public function index ():Response
    {
        $projets = $this->repo->findAll();
        
        return $this->render("/admin/index.html.twig", compact('projets')); 
        
    } 
    public function new (Request $Request)
    {
        $projets = new Projet();
        $form = $this->createForm(ProjetType::class, $projets);
        $form->handleRequest($Request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($projets);
            $this->em->flush();
            $this->addFlash('success', 'Projet créé avec succès');

            return $this->redirectToRoute('admin.projet.index');
        }

        return $this->render('admin/new.html.twig', [
            'projets' => $projets,
            'form' => $form->createView(),
        ]);     
    }
}