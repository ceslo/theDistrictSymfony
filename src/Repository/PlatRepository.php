<?php

namespace App\Repository;

use App\Entity\Detail;
use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Plat>
 *
 * @method Plat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plat[]    findAll()
 * @method Plat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plat::class);
    }


public function getPlatsByCat($id, EntityManagerInterface $entityManager)
{
    $queryBuilder=$entityManager->createQueryBuilder();

    $queryBuilder->select('p')
    ->from(Plat::class,'p')
    ->where('p.categorie = :cat_id')
    ->setParameter('cat_id', $id);
    
    $query=$queryBuilder->getQuery();
    
    $platsByCat=$query->getResult();
    return $platsByCat;
}

public function getPopularMeals(EntitymanagerInterface $entityManager)
{
   
// $queryBuilder = $entityManager->createQueryBuilder();

// $queryBuilder
//     ->select('p, SUM(d.quantite) AS totalQuantite') // Sélectionnez le plat et la somme des quantités
//     ->from(Plat::class, 'p')
//     ->join(Detail::class, 'd', 'WITH', 'd.plat = p') // Joignez les détails avec les plats
//     ->groupBy('p') // Groupez par plat
//     ->orderBy('totalQuantite', 'DESC') // Triez par la somme des quantités
//     ->setMaxResults(3);

// $query = $queryBuilder->getQuery();
// $popularMeals = $query->getResult();

// return $popularMeals;

    $queryBuilder=$entityManager->createQueryBuilder();
    
    $queryBuilder
        ->select('p')
        ->from(Plat::class,'p')
        ->join(Detail::class,'d', 'WITH', 'p.id = d.plat')
        ->groupBy('p')
        ->orderBy('SUM(d.quantite)','DESC')
        ->setMaxResults(3);
        $query=$queryBuilder->getQuery();

        $popularMeals=$query->getResult();
        return $popularMeals;

}
function search_bar($keyword, EntityManagerInterface $entityManager)
{ 
    $queryBuilder= $entityManager->createQueryBuilder();

    $queryBuilder
        ->select('p')
        ->from(Plat::class, 'p')
        ->where('libelle LIKE :key')
        ->setparameter('key', '%'.$keyword.'%');
        $query=$queryBuilder->getQuery();
        //  where libelle LIKE '%$keyword%' OR description LIKE '%$keyword%'");
   
    $result=$query->getResult();
    return $result;
}

    //    /**
    //     * @return Plat[] Returns an array of Plat objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Plat
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
