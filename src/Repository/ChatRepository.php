<?php

namespace App\Repository;

use App\Entity\Chat;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Chat>
 */
class ChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chat::class);
    }

    //    /**
    //     * @return Chat[] Returns an array of Chat objects
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

        public function findPrivateChat(User $user1, User $user2): ?Chat
        {
            return $this->createQueryBuilder('c')
                ->andWhere(':user1 in c.Members')
                ->andWhere(':user2 in c.Members')
                ->andWhere('c.Members count = 2')
                ->setParameter('user1', $user1)
                ->setParameter('user2', $user1)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
