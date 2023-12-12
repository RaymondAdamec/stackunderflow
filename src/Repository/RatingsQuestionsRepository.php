<?php

namespace App\Repository;

use App\Entity\RatingsQuestions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RatingsQuestions>
 *
 * @method RatingsQuestions|null find($id, $lockMode = null, $lockVersion = null)
 * @method RatingsQuestions|null findOneBy(array $criteria, array $orderBy = null)
 * @method RatingsQuestions[]    findAll()
 * @method RatingsQuestions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingsQuestionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RatingsQuestions::class);
    }

//    /**
//     * @return RatingsQuestions[] Returns an array of RatingsQuestions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RatingsQuestions
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
