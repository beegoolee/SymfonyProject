<?php

namespace App\Controller\Ajax;

use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\ChatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AjaxChatController extends AbstractController
{
    #[Route('/ajax/chat/remove/{id}', name: 'app_chat_remove')]
    public function chatRemove(Chat $chat, EntityManagerInterface $em): Response
    {
        $em->remove($chat);
        $em->flush();

        return $this->redirectToRoute('app_chats_list');
    }

    #[Route('/ajax/chat-message/remove/{chatId}/{id}/', name: 'app_chat_msg_remove')]
    public function chatMsgRemove($chatId, Message $message, EntityManagerInterface $em): Response
    {
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute('app_chat', ['id' => $chatId]);
    }

    #[Route('/ajax/chat/add/private/{user1}/{user2}/', name: 'app_add_private_chat')]
    public function makePrivateChat(User $user1, ?User $user2, EntityManagerInterface $em): Response
    {
        $chatRepo = $em->getRepository(Chat::class);

        if ($chat = $chatRepo->findPrivateChat($user1, $user2)) {
        } else {
            $chat = new Chat();

            $now = new \DateTime('now');

            $chat->setCreatedAt($now);
            $chat->setUpdatedAt($now);
            $chat->setPrivate(true);
            $chat->addMember($user1);
            $chat->addMember($user2);
            $chat->setChatOwner($user1);
            $chat->setName($user2->getUserDisplayName() . " || " . $user1->getUserDisplayName());

            $em->persist($chat);
            $em->flush();
        }

        return $this->redirectToRoute('app_chat', ['id' => $chat->getId()]);
    }
}
