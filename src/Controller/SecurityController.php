<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\AccountValidation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @Route("/accountValidation/{token}", name="app_valid_account")
     */
    public function validAccount(AccountValidation $accountValidation, $token)
    {
        if (!$accountValidation) {
            return $this->redirectToRoute('accueil');
        }
        $accountValidation->getUser()->setValid(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($accountValidation);
        $entityManager->remove($accountValidation);
        $entityManager->flush();

        return $this->redirectToRoute('app_login');
    }
}
