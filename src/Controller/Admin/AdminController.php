<?php

namespace App\Controller\Admin;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * Create a project.
     *
     * @Route("/admin/projet/creation", name="admin.new")
     *
     * @return void
     */
    public function new(Request $request)
    {
        /*création d'un nouveau projet grâce à l'appel de l'entity Projet */
        $projets = new Projet();
        /*création d'un formulaire avec ProjetType comme view et la valeur de la variable $projets donc Projet */
        $form = $this->createForm(ProjetType::class, $projets);
        /*utilisé le framework pour lire la requête HTTP */
        $form->handleRequest($request);

        /*vérification du formulaire par 2 critères la soumission et la validité */
        if ($form->isSubmitted() && $form->isValid()) {
            /* si le formulaire est soumit ET valide, alors persist les infos dans la bdd. flush les nouvelles données et envoie un message success si c'est valide. enfin une fois que les conditions sont réunion redirection l'user sur index*/
            $this->em->persist($projets);
            $this->em->flush();
            $this->addFlash('success', 'Le projet a été créé avec succès !');

            return $this->redirectToRoute('admin.index');
        }

        return $this->render('/admin/new.html.twig', [
            'projets' => $projets,
            'form' => $form->createView(),
        ]);
    }

    /*=================================================================================*/

    /**
     * Edit a project.
     *
     * @Route("/admin/projet/modifier/{id}", name="admin.edit", methods="GET|POST")
     *
     * @return void
     */
    public function edit(Projet $projet, Request $request)
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($projet);
            $this->em->flush();
            $this->addFlash('success', 'Le projet a été modifié avec succès !');

            return $this->redirectToRoute('admin.index');
        }

        return $this->render('/admin/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /*=================================================================================*/

    /**
     * Delete a projet.
     *
     * @Route("/admin/projet/supprimer/{id}", name="admin.delete", methods="DELETE")
     *
     * @return void
     */
    public function delete(Projet $projet, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->get('_token'))) {
            $this->em->remove($projet);
            $this->em->flush();
            $this->addFlash('success', 'Le projet a été supprimé avec succès !');
        }

        return $this->redirectToRoute('admin.index');
    }
}
