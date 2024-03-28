<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InscriptionController extends AbstractController
{
    

    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $form=$this->createForm(UtilisateurFormType::class);
        $form->handleRequest($request);

        if ($form-> isSubmitted() && $form->isValid())
        {
            $utilisateur= new Utilisateur();
            $data=$form->getData();
            $utilisateur= $data;
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_catalogue');

        }

        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
            'form'=>$form,
        ]);
    }
}
