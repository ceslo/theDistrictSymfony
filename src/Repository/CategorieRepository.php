<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
    public function getCategorieByPopularity()
    {
        $entityManager = $this->getEntityManager();

        $query= $this->createQueryBuilder('categorie');
        $query
            -> select('categorie , SUM(details.quantite) AS quantiteTotale') 
            ->from ('App\Entity\Categorie', 'categorie')
            ->join('App\Entity\Plat', 'plat', 'categorie.id=plat.categorie_id')
            ->join ('App\Entity\Details', 'details', 'details.plat_id=plat.id')
            ->groupBy('categorie.id')          
            ->orderBy('quantiteTotale')
            ->setMaxResults(6)
            ->getQuery();

            $categories= $query->getResult();
            return $categories;
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
