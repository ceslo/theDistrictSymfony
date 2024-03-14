<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalogueController extends AbstractController
{
    #[Route('/', name: 'app_catalogue')]
    public function index(): Response
    {
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
        ]);
    }
    #[Route('/plats', name: 'app_plats')]
    public function affichage_plat(): Response
    {

        return $this->render('catalogue/plats.html.twig', [
            'controller_name' => 'CatalogueController',
        ]);
    }
    #[Route('/plats/{categorie_id}', name: 'app_platsByCat')]
    public function affichage_platByCat(): Response
    {
        
        return $this->render('catalogue/plats/{categorie_id}.html.twig', [
            'controller_name' => 'CatalogueController',
        ]);
    }

    #[Route('/categories', name: 'app_categories')]
    public function affichage_categorie(): Response
    {
        
        return $this->render('catalogue/categories.html.twig', [
            'controller_name' => 'CatalogueController',
        ]);
    }


}