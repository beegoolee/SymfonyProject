<?php

namespace App\Controller\Ajax;

use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AjaxFriendsController extends AbstractController
{
    #[Route('/ajax/friends/{action}/{myself}/{friend}', name: 'app_friend_action')]
    public function friendAction(string $action, User $myself, User $friend, EntityManagerInterface $em): Response
    {
        switch ($action){
            case "add":
                $myself->addFriend($friend);
                break;
            case "remove":
                $myself->removeFriend($friend);
                break;
        }

        $em->flush();

        return $this->redirectToRoute('app_profile', ['id'=>$myself->getId()]);
    }
}
