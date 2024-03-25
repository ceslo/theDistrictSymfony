<?php
namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class CatalogueController extends AbstractController
{

    // private $catRepo;
    // private $platsRepo;

    //  public function __construct(PlatRepository $platsRepo, CategorieRepository $catRepo)
    // {
    //     $this -> platsRepo = $platsRepo;
    //     $this -> catRepo = $catRepo;
    // }

    #[Route('/', name: 'app_catalogue')]
    public function index( EntityManagerInterface $entity, PlatRepository $platsRepo, CategorieRepository $catRepo): Response
    {
        $popularCategories=$catRepo-> getPopularCategories();
        $popularMeals=$platsRepo->getPopularMeals($entity);
        // var_dump($popularCategories);
        // var_dump($popularMeals);
        //
        return $this->render('catalogue/index.html.twig', [
            'controller_name' => 'CatalogueController',
            'popularCategories'=>$popularCategories,
            'popularMeals'=>$popularMeals,     
        ]);
    }
    #[Route('/plats', name: 'app_plats')]
    public function affichage_plat(PlatRepository $platsRepo): Response
    {
        $plats=$platsRepo->findAll();
       
        return $this->render('catalogue/plats.html.twig', [
            'controller_name' => 'CatalogueController',
            'plats'=> $plats,
        ]);
    }
    #[Route('/plats/{categorie_id}', name: 'app_platsByCat{categorie_id}')]
    public function affichage_platByCat(HttpFoundationRequest $request,PlatRepository $platsRepo): Response
    {
        $id=$request->attributes->get('categorie_id');
        $plats=$platsRepo->findBy(['categorie'=>$id]);
        // $plats= $platsRepo->getplatByCat($id);
        // var_dump($plats);
        return $this->render('catalogue/plats_id.html.twig', [
            'controller_name' => 'CatalogueController',
            'plats'=> $plats
        ]);
    }

    #[Route('/categories', name: 'app_categories')]
    public function affichage_categorie(CategorieRepository $catRepo): Response
    {
        $categories=$catRepo-> findAll();

        return $this->render('catalogue/categories.html.twig', [
            'controller_name' => 'CatalogueController',
            'categories'=>$categories
        ]);
    }


}