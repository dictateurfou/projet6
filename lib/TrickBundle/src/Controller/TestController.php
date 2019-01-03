<?php

// src/Controller/HelloController.php
namespace SnowTrick\TrickBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trick;

class TestController extends AbstractController
{


    /**
     * Page d'info d'un trick
     *
     * @Route("/test/{trickId}", name="trick")
     */
    public function showTrick($trickId)
    {
        $trick = $this->getDoctrine()
        ->getRepository(Trick::class)
        ->find($trickId);

        if (!$trick) {
            return $this->redirectToRoute("accueil");
        }

        return $this->render('trick.html.twig', ['post' => $trickId,'trick' => $trick]);
    }
}