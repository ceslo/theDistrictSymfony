<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Detail;
use App\Repository\PlatRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\PanierService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(PanierService $panierService,PlatRepository $platRepo, EntityManagerInterface $entityManager, UtilisateurRepository $UserRepo, MailerInterface $mailer): Response
    {
        $utilisateur= $UserRepo->findOneBy(["email"=>'blabla@gmail.com']);
        $panier_detail= $panierService->IndexPanier($platRepo);
        $total=$panierService->totalPanier($panier_detail);
        // dd($panier_detail);
        $commande =new Commande;
        $commande->setDateCommande(new DateTime())
                 ->setTotal($total)
                 ->setEtat(0)
                 ->setUtilisateur($utilisateur);
        $entityManager->persist($commande);
        $entityManager->flush();

        foreach($panier_detail as $item)
        {
            $plat=$item['plat'];
            $quantite=$item['quantite'];
            $detail=new Detail;
            $detail->setQuantite($quantite);
            $detail->setPlat($plat);
            $detail->setCommande($commande);
            $entityManager->persist($detail);
            
        };
        
        $entityManager->flush();
        $utilisateur_mail= $utilisateur->getEmail();

        $mail= (new Email());
        $mail->from('from@thedistrict.com')
         ->to($utilisateur_mail)
         ->Subject('Confimation de votre commande')
         ->html("<h1>Merci pour votre commande!</h1><div> A très bientôt chez The District </div>");
        $mailer->send($mail);

        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
