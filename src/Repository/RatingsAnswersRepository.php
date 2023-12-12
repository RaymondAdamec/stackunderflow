<?php

namespace App\Repository;

use App\Entity\RatingsAnswers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RatingsAnswers>
 *
 * @method RatingsAnswers|null find($id, $lockMode = null, $lockVersion = null)
 * @method RatingsAnswers|null findOneBy(array $criteria, array $orderBy = null)
 * @method RatingsAnswers[]    findAll()
 * @method RatingsAnswers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingsAnswersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RatingsAnswers::class);
    }

//    /**
//     * @return RatingsAnswers[] Returns an array of RatingsAnswers objects
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

//    public function findOneBySomeField($value): ?RatingsAnswers
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
