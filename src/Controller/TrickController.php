<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use SnowTrick\TrickBundle\Entity\Trick;
use App\Entity\Category;

/** @Route("/trick", name="blog_") */
class TrickController extends AbstractController
{


    /**
     * Page d'info d'un trick
     *
     * @Route("/view/{trickId}", name="trick view")
     */
    public function showTrick($trickId)
    {
        $trick = $this->getDoctrine()
        ->getRepository(Trick::class)
        ->find($trickId);

        if (!$trick) {
            return $this->redirectToRoute("accueil");
        }

        return $this->render('trick.html.twig', ['trick' => $trick]);
    }

    /**
     * Page d'ajout d'un trick
     *
     * @Route("/add", name="add trick")
     */
    public function addTrick(Request $request){
        $trick = new Trick();
        $categoryList = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findAll();
        $form = $this->createFormBuilder($trick)
        ->add('name', TextType::class,array('label' => "Nom"))
        ->add('description', TextareaType::class,array('label' => "Description"))
        ->add('category', EntityType::class, array('class' => Category::class,
            'choices' => $categoryList,'choice_label' => 'getName',
            'placeholder' => 'Categorie','label' => 'Categorie'))
        ->add('videoList', CollectionType::class, array(
            'entry_type' => TextType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'required'      => true,       
            'prototype' => true,
            'entry_options' => array(
                'attr' => array('class' => 'videoList-box'),
            ),
        ))
        ->add('valider', SubmitType::class, array('label' => 'Valider'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            var_dump($data);
        }
        return $this->render('trick/add.html.twig', ['form' => $form->createView()]);
    }
}