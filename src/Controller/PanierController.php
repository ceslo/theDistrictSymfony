<?php

namespace App\Controller;

use App\Repository\PlatRepository;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, PlatRepository $platRepository): Response
    {
        $panier=$session->get('panier',[]);
        
        $panier_details=[];
        foreach($panier as $id=>$quantity)
        {
            $panier_details[]=[
                'plat'=>$platRepository->find($id),
                'quantite'=>$quantity,
            ];
        } 
        // dd($panier_details);  

        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'items'=> $panier_details,
        ]);
    }
    #[Route('/panier/ajout/{id}', name: 'app_panier_ajout')]
    public function ajout($id, SessionInterface $session): Response
    {


        $panier= $session->get('panier',[]);
        if(!empty($panier[$id]))
        {
            $panier[$id]++;
        }
        else{
            $panier[$id]=1;
        }
       
        $session->set('panier',$panier);
        // dd($panier);
        return $this->render('panier/ajout.html.twig', [
            'controller_name' => 'PanierController',
            'panier'=>$panier
        ]);
    }
}
