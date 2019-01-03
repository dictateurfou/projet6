<?php

// src/Controller/HelloController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;

class AccountController extends AbstractController
{
    /**
     * Page d'inscription
     *
     * @Route("/inscription", name="inscription")
     */
    public function register(Request $request)
    {
        $user = new User();
        $form = $this->createFormBuilder($user)
        ->add('name', TextType::class)
        ->add('pass', PasswordType::class)
        ->add('mail', EmailType::class)
        ->add('valider', SubmitType::class, array('label' => 'Valider'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $user->setAvatar('img/profile/default.png');
            $user->setPass(hash('sha256', $user->getPass()));
            
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();
        }

        return $this->render('account/register.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Page de connection,
     *
     * @Route("/connection", name="connection")
     */
    public function connect()
    {

        return $this->render('account/connect.html.twig', ['form' => $form->createView()]);
    }
}