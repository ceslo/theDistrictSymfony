<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Plat;
use App\Entity\Utilisateur;
use App\Repository\CategorieRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use function Symfony\Component\Clock\now;

class DatabaseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
 
        // $product = new Product();
        // $manager->persist($product);
        include "the_district.php";
       
        foreach ($categorie as $cat){
            $catDB= new Categorie;
            $catDB-> setId($cat['id']);
            $catDB-> setLibelle($cat['libelle']);
            $catDB-> setImage($cat['image']);
            $catDB-> setActive($cat['active']);
        
        // Pour empecher l'auto-incrementation de l'Id:
        $metadata= $manager->getClassMetadata(Categorie::class);
        $metadata-> setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        
        $manager->persist($catDB);
        }
        $manager->flush();

        $categorieRepo= $manager->getRepository(Categorie::class);
        foreach ($plat as $p){
            $platDB= new Plat;
            $platDB-> setId($p['id']);
            $platDB-> setLibelle($p['libelle']);
            $platDB-> setDescription($p['description']);
            $platDB-> setPrix($p['prix']);
            $platDB-> setImage($p['image']);
            $platDB-> setActive($p['active']);

            $categorie= $categorieRepo->find($p['id_categorie']);
            $platDB-> setCategorie($categorie);
        
        // Pour empecher l'auto- incrementation de l'Id:
        $metadata= $manager->getClassMetadata(Plat::class);
        $metadata-> setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        
        $manager->persist($platDB);

        $manager->flush();
        }

        $utilisateur1= new Utilisateur;
        $utilisateur1->setEmail('schrutebeetsfarm@dm.com');
        $utilisateur1->setPassword('$2y$13$3GhmL6IIAVr04t/gZC/E4eZio1bNz3JySS0lDiJ1tGrkSZxqx7keS');
        $utilisateur1->setNom('Schrute');
        $utilisateur1->setPrenom('Dwight');
        $utilisateur1->setAdresse("schute's farm BB");
        $utilisateur1->setCp('00000');
        $utilisateur1->setVille('Scranton');
        $utilisateur1->setTelephone('0101010101');

        $utilisateur2= new Utilisateur;
        $utilisateur2->setEmail('michaelscott@dm.com');
        $utilisateur2->setPassword('$2y$13$Bb7RiRQ3XZO8dcoDs2Tm6.uI9c7ewdskVkZw8/kLVPFDmwk1s0ecu');
        $utilisateur2->setNom('Scott');
        $utilisateur2->setPrenom('Michael');
        $utilisateur2->setAdresse("lalaland");
        $utilisateur2->setCp('00000');
        $utilisateur2->setVille('Scranton');
        $utilisateur2->setTelephone('0202020202');
        
        $manager->persist($utilisateur1);
        $manager->persist($utilisateur2);

        $manager->flush();

        $clients= $manager->getRepository(Utilisateur::class);
        $client1=$clients->findOneBy(['email' => 'michaelscott@dm.com']);
        $client2=$clients->findOneBy(['nom' => 'Schrute']);

     //    $id=$client1->getId();
        $commande1= new Commande;
        // 1 pizza bianca
        $commande1->setUtilisateur($client1);
        $commande1->setTotal('14.00');
        $commande1->setEtat('0');
        $commande1->setDateCommande(new DateTime());
        $manager->persist($commande1);
        
        $commande2= new Commande;
        // 1 cheeseburber+ 1 tagliatelles au saumon
        $commande2->setUtilisateur($client1);
        $commande2->setTotal('20.00');
        $commande2->setEtat('0');
        $commande2->setDateCommande(new DateTime());
        $manager->persist($commande2);

        $commande3= new Commande;
        // 1 district burger
        $commande3->setUtilisateur($client2);
        $commande3->setTotal('8.00');
        $commande3->setEtat('0');
        $commande3->setDateCommande(new DateTime());
        $manager->persist($commande3);

        $manager->flush();


    }
}
   