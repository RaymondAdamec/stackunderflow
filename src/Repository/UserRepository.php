<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }


    //used to find the total scoring for all questions of every user:
    public function findScoringQuestion($id)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->select('u.email', 'u.id', 'SUM(r.Votes) as totalVotes')
            ->leftJoin('App\Entity\Questions', 'q', 'WITH', 'u.id = q.fk_id_user')
            ->leftJoin('App\Entity\RatingsQuestions', 'r', 'WITH', 'q.id = r.fk_id_question')
            ->where('u.id = :userId') // Add condition to filter by user ID
            ->setParameter('userId', $id)
            ->groupBy('u.id')
            ->setMaxResults(1);
        return $query = $qb->getQuery()->getOneOrNullResult();
    }


    //used to find the total scoring for all questions of every user:
    public function findScoringAnswer($id)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->select('u.email', 'u.id', 'SUM(r.Votes) as totalVotes')
            ->leftJoin('App\Entity\Questions', 'q', 'WITH', 'u.id = q.fk_id_user')
            ->leftJoin('App\Entity\RatingsAnswers', 'r', 'WITH', 'q.id = r.fk_id_answers')
            ->where('u.id = :userId') // Add condition to filter by user ID
            ->setParameter('userId', $id)
            ->groupBy('u.id')
            ->setMaxResults(1);
        return $query = $qb->getQuery()->getOneOrNullResult();
    }

    //used to find the total scoring for all questions of every user:
    public function findQuestionsOfUser($id)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->select('u.email', 'u.id', 'Count(q.id) as totalQuestions')
            ->leftJoin('App\Entity\Questions', 'q', 'WITH', 'u.id = q.fk_id_user')
            ->where('u.id = :userId') // Add condition to filter by user ID
            ->setParameter('userId', $id)
            ->groupBy('u.id')
            ->setMaxResults(1);
        return $query = $qb->getQuery()->getOneOrNullResult();
    }

    //used to find the total scoring for all questions of every user:
    public function findAnswersOfUser($id)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->select('u.email', 'u.id', 'Count(a.id) as totalAnswers')
            ->leftJoin('App\Entity\Answers', 'a', 'WITH', 'u.id = a.fk_id_user')
            ->where('u.id = :userId') // Add condition to filter by user ID
            ->setParameter('userId', $id)
            ->groupBy('u.id')
            ->setMaxResults(1);
        return $query = $qb->getQuery()->getOneOrNullResult();
    }

    //used to find the user with the highest voting for his/her question
    public function findUserVotes()
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->select('u.email', 'u.id', 'SUM(r.Votes) as totalVotes')
            ->leftJoin('App\Entity\Questions', 'q', 'WITH', 'u.id = q.fk_id_user') // 'user' ist der Feldname in der Question-Entität, das auf die User-Entität verweist
            ->leftJoin('App\Entity\RatingsQuestions', 'r', 'WITH', 'q.id = r.fk_id_question') // 'question' ist der Feldname in der Rating-Entität, das auf die Question-Entität verweist
            ->groupBy('u.id')
            ->orderBy('totalVotes', 'DESC')
            ->setMaxResults(1);
        return $query = $qb->getQuery()->getOneOrNullResult();
    }



    public function findbestQuestion()
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->select('u.id', 'u.email', 'q.title', 'SUM(r.Votes) as totalVotes')
            ->leftJoin('App\Entity\Questions', 'q', 'WITH', 'u.id = q.fk_id_user') // 'user' ist der Feldname in der Question-Entität, das auf die User-Entität verweist
            ->leftJoin('App\Entity\RatingsQuestions', 'r', 'WITH', 'q.id = r.fk_id_question') // 'question' ist der Feldname in der Rating-Entität, das auf die Question-Entität verweist
            ->groupBy('q.id')
            ->orderBy('totalVotes', 'DESC')
            ->setMaxResults(1);
        return $query = $qb->getQuery()->getOneOrNullResult();
    }

    public function findBestAnswer()
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->select('u.id', 'u.email', 'a.title', 'SUM(r.Votes) as totalVotes')
            ->leftJoin('App\Entity\Answers', 'a', 'WITH', 'u.id = a.fk_id_user') // 'user' ist der Feldname in der Question-Entität, das auf die User-Entität verweist
            ->leftJoin('App\Entity\RatingsAnswers', 'r', 'WITH', 'a.id = r.fk_id_answers') // 'question' ist der Feldname in der Rating-Entität, das auf die Question-Entität verweist
            ->groupBy('a.id')
            ->orderBy('totalVotes', 'DESC')
            ->setMaxResults(1);
        return $query = $qb->getQuery()->getOneOrNullResult();
    }



    public function findInactiveUsers()
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->leftJoin('App\Entity\Answers', 'a', 'WITH', 'u.id = a.fk_id_user')
            ->leftJoin('App\Entity\Questions', 'q', 'WITH', 'u.id = q.fk_id_user')
            ->where('q.created_at IS NULL')
            ->andWhere('a.created_at IS NULL');

        return $qb->getQuery()->getResult();
    }


    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
