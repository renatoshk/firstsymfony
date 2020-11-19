<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }
//sdsd
     /**
     * @return Article[]
    */
    public function findAllPublishedByNewest()
    {

            return $this->addIsPublishedQueryBuilder()
            ->orderBy('a.publishedAt','DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public static function createNonDeletedCriteria():Criteria {
        return Criteria::create()
            ->andWhere(Criteria::expr()->eq('isDeleted',false));
    }
    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    private function addIsPublishedQueryBuilder(QueryBuilder $queryBuilder = null){
        return $this->getOrCreateQueryBuilder($queryBuilder)
                ->andWhere('a.publishedAt IS NOT NULL');
    }
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null){
         return $queryBuilder ?: $this->createQueryBuilder('a');
    }
}
