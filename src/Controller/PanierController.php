<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(PanierService $panierService, PlatRepository $platRepository): Response
    {
        // dd($total);
        $panier_details=$panierService->IndexPanier($platRepository);
        $total=$panierService->totalPanier($panier_details);
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'items'=> $panier_details,
            'total'=>$total,
        ]);
    }
    #[Route('/panier/ajout/{id}', name: 'app_panier_ajout')]
    public function ajout($id, PanierService $panierService, Request $request): Response
    {
        $id=$request->attributes->get('id');

        $panierService-> addToCart($id);

        // Pour obtenir la route actuelle        
        $currentRoute = $request->attributes->get('_route');
        
        // dd($panier);
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/removeAll/{id}', name: 'app_panier_supprAll')]
    public function removeAll ($id , Request $request, PanierService $panierService): Response
    {
        $id=$request->attributes->get('id');
        $panierService->removeAllFromCart($id);
        return $this->redirectToRoute('app_panier');

        //  // Pour obtenir la route actuelle        
        //  $currentRoute = $request->attributes->get('_route');

        // return $this->redirectToRoute($currentRoute);
    }

    #[Route('/panier/removeOne/{id}', name: 'app_panier_supprOne')]
    public function removeOne ($id , Request $request, PanierService $panierService): Response
    {
        $id=$request->attributes->get('id');
        $panierService->removeOneFromCart($id);
        return $this->redirectToRoute('app_panier');

        //  // Pour obtenir la route actuelle        
        //  $currentRoute = $request->attributes->get('_route');

        // return $this->redirectToRoute($currentRoute);
    }

   
}