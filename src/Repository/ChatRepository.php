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

        public function findPrivateChat(User $user1, User $user2)
        {
            // TODO - переделать через QueryBuilder, фильтрация результатов должна происходить на этапе запроса в БД
//
//            $a= $this->createQueryBuilder('c')
//                ->innerJoin('c.user', 'u')
//                ->andWhere('c.isPrivate = true')
//                ->andWhere('c.Members = :user1 AND c.Members = :user2')
//                ->setParameter('user1', $user1)
//                ->setParameter('user2', $user2)
//                ->getQuery()
//            ;
//            dd($a,$a->getResult());

            $arAllChats = $this->findAll();
            foreach($arAllChats as $chat){
                $members = $chat->getMembers();
                $arMembers = $members->getValues();
                if(count($arMembers) == 2){
                    if(in_array($user1, $arMembers) && in_array($user2, $arMembers)){
                        return $chat;
                    }
                }
            }
            return null;
        }
}
