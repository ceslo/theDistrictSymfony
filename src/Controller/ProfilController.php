<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{

    private $utilisateurRepo;
    public function __construct(UtilisateurRepository $utilisateurRepo)
    { 
        $this->utilisateurRepo= $utilisateurRepo;        
    }

    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        $identifiant=$this->getUser()->getUserIdentifier();
        if($identifiant){
            $info = $this->utilisateurRepo->findOneBy(["email"=>$identifiant]);
        }
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'informations'=>$info
        ]);
    }
}
