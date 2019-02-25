<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Trick;
use App\Entity\Image;
use App\Form\TrickType;
use App\Service\ImageUploader;
use App\Service\VideoLinkValidator;

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
    public function addTrick(Request $request,ImageUploader $fileUploader,VideoLinkValidator $videoLinkvalidator){
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
            $fileUploader->upload($trick->getImageList());
            $entityManager->persist($trick);
           
            $entityManager->flush();
            
        }
        return $this->render('trick/add.html.twig', ['form' => $form->createView()]);
    }


    /**
    * Page d'ajout d'un trick
    *
    * @Route("/edit/{trick}", name="add trick")
    */
    public function editTrick(Request $request,ImageUploader $fileUploader,VideoLinkValidator $videoLinkvalidator,Trick $trick){
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $fileUploader->uploadEdit($trick);
            $trick->setVideoList($videoLinkvalidator->checkUrl($trick->getVideoList()));
            $entityManager->persist($trick);
            $trick->setEdited("yes");
            $date = new \DateTime();
            $date->format('Y-m-d H:i:s');
            $trick->setEditedAt($date);
            $entityManager->flush();
        }
        return $this->render('trick/edit.html.twig', ['form' => $form->createView()]);
    }


}
