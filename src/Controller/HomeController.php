<?php

// src/Controller/HelloController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use SnowTrick\TrickBundle\Entity\Trick;
use App\Entity\Category;

class HomeController extends AbstractController
{
    /**
     * Page d'accueil
     *
     * @Route("/", name="accueil")
     */
    public function home()
    {
        $test = new \SnowTrick\TrickBundle\TrickBundle();
        $test->test();
        return $this->render('home.html.twig', []);
    }

    /**
     * Page d'info d'un trick
     *
     * @Route("/trick/{trickId}", name="trick")
     */
    public function showTrick($trickId)
    {
        $trick = $this->getDoctrine()
        ->getRepository(Trick::class)
        ->find($trickId);

        if (!$trick) {
            return $this->redirectToRoute("accueil");
        }

        return $this->render('trick.html.twig', ['trickId' => $trickId,'trick' => $trick]);
    }
}