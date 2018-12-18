<?php

// src/Controller/HelloController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trick;

class HomeController extends AbstractController
{
    /**
     * Page d'accueil
     *
     * @Route("/", name="accueil")
     */
    public function home()
    {
        return $this->render('home.html.twig', []);
    }

    /**
     * Page d'info d'un trick
     *
     * @Route("/trick/{postId}", name="trick")
     */
    public function showTrick($postId)
    {
        $trick = $this->getDoctrine()
        ->getRepository(Trick::class)
        ->find($postId);

        if (!$trick) {
            return $this->redirectToRoute("accueil");
        }

        return $this->render('trick.html.twig', ['post' => $postId,'trick' => $trick]);
    }
}