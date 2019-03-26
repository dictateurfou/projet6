<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Trick;
use App\Entity\Image;
use App\Entity\Discussion;
use App\Form\TrickType;
use App\Form\DiscussionType;
use App\Service\ImageUploader;
use App\Service\VideoLinkValidator;

/** @Route("/trick", name="blog_") */
class TrickController extends AbstractController
{


    /**
     * Page d'info d'un trick
     *
     * @Route("/view/{trickId}", name="trick_view")
     */
    public function showTrick(Request $request,$trickId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $trick = $this->getDoctrine()
        ->getRepository(Trick::class)
        ->find($trickId);

        $comment = new Discussion();
        if (!$trick) {
            return $this->redirectToRoute("accueil");
        }

        $form = $this->createForm(DiscussionType::class,$comment);
        $form->handleRequest($request);
        $user = $this->getUser();

        $repositoryComment = $this->getDoctrine()->getRepository(Discussion::class);
 
        if($form->isSubmitted() && $form->isValid() && $user !== null) {
            $comment->setAuthor($user);
            $comment->setTrick($trick);

            $entityManager->persist($comment);
            $entityManager->flush();

        }

        return $this->render('trick.html.twig', ['trick' => $trick,'form' => $form->createView()]);
    }

    /**
     * Page d'ajout d'un trick
     *
     * @Route("/add", name="add_trick")
     */
    public function addTrick(Request $request,VideoLinkValidator $videoLinkvalidator){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $trick = new Trick();
        $date = new \DateTime();
        $date->format('Y-m-d H:i:s');
        $image = new Image();
        $trick->addImageList($image);
        $trick->setEditedAt($date);
        $trick->setCreatedAt($date);
        $trick->setVideoList(array(""));
        $trick->setEdited("no");
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $trick->getImageList();
            $data = $form->getData();
            $trick->setVideoList($videoLinkvalidator->checkUrl($trick->getVideoList()));
            $entityManager->persist($trick);
           
            $entityManager->flush();
            $form = $this->createForm(TrickType::class, $trick);
            
        }
        return $this->render('trick/add.html.twig', ['form' => $form->createView()]);
    }


    /**
    * Page d'ajout d'un trick
    *
    * @Route("/edit/{trick}", name="edit_trick")
    */
    public function editTrick(Request $request,VideoLinkValidator $videoLinkvalidator,Trick $trick){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $trick->setVideoList($videoLinkvalidator->checkUrl($trick->getVideoList()));
            $entityManager->persist($trick);
            $trick->setEdited("yes");
            $date = new \DateTime();
            $date->format('Y-m-d H:i:s');
            $trick->setEditedAt($date);
            $entityManager->flush();
            $form = $this->createForm(TrickType::class, $trick);
        }
        return $this->render('trick/edit.html.twig', ['form' => $form->createView()]);
    }


}
