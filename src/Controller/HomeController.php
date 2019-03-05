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

        return $this->render('home.html.twig', []);
    }

}