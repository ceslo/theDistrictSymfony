<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Detail;
use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Bundle\MakerBundle\Util\ClassDetails;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }
    
    public function getPopularCategories()
    {
        $entityManager = $this->getEntityManager();
        

        $queryBuilder= $entityManager->createQueryBuilder();
        $queryBuilder
            ->select('c') 
            ->from (Categorie::class, 'c')
            ->join(Plat::class, 'p','WITH', 'p.categorie= c.id')
            ->join (Detail::class, 'd','WITH', 'p.id = d.plat')
            ->groupBy('c') 
            ->addGroupBy('p')         
            ->orderBy('SUM(d.quantite)','DESC')
            ->setMaxResults(3);
            $query=$queryBuilder->getQuery();
        
            $popularCat=$query->getResult();
            return $popularCat;
  }

    //    /**
    //     * @return Categorie[] Returns an array of Categorie objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Categorie
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
