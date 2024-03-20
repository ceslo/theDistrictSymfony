<?php

namespace App\Repository;

use App\Entity\Detail;
use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

public function getPopularMeals(entitymanagerInterface $entityManager)
{
    $queryBuilder=$entityManager->createQueryBuilder();
    
    $queryBuilder
        ->select('p')
        ->from(Plat::class,'p')
        ->join(Detail::class,'d')
        ->groupBy('p')
        ->orderBy('SUM(d.quantite)','DESC')
        ->setMaxResults(3);
        $query=$queryBuilder->getQuery();

        $popularMeals=$query->getResult();
        return $popularMeals;

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
