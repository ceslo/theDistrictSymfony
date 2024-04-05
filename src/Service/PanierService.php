<?php

namespace App\Service;

use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;


class PanierService {

    public function __construct(private RequestStack $requestStack){}

    public function IndexPanier(PlatRepository $platRepository)
    {
        // Je recupère la session
        $session=$this->requestStack->getSession();

        // Je recupère le panier dans la session, sous la forme d'un tableau.
        $panier=$session->get('panier',[]);
        
        // Je crée un panier avec les détails des plats
        $panier_details=[];
        foreach($panier as $id=>$quantity)
        {
            $panier_details[]=[
                'plat'=>$platRepository->find($id),
                'quantite'=>$quantity,
            ];
        } ;
        // dd($panier_details);
        return $panier_details;
    }

    public function totalPanier($panier_details){
        // Je calcule le prix total du panier
        $total=0;
        foreach($panier_details as $item)
        {
            $totalItem= ($item['plat']->getPrix()) * $item['quantite'];
            $total += $totalItem;
        };
        return $total;
        }    

    public function addToCart($id)
    {
        $session=$this->requestStack->getSession();
        $panier= $session->get('panier',[]);
        if(!empty($panier[$id]))
        {
            $panier[$id]++;
        }
        else{
            $panier[$id]=1;
        }
       
        $session->set('panier',$panier);
              
    }    
    
    public function removeAllFromCart($id)
    {
        $session=$this->requestStack->getSession();
        $panier=$session->get('panier',[]);
        if(!empty($panier[$id]))
        {
            unset($panier[$id]);
        }

        $session->set('panier',$panier);
        
    }
    public function removeOneFromCart($id)
    {        
        $session=$this->requestStack->getSession();
        $panier= $session->get('panier',[]);
        if($panier[$id]>1)
        {
            $panier[$id]--;
        }
        else{
            unset($panier[$id]);
        }
       
        $session->set('panier',$panier);
        
    }
}