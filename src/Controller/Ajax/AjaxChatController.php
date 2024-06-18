<?php

namespace App\Controller\Ajax;

use App\Entity\Chat;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AjaxChatController extends AbstractController
{
    #[Route('/ajax/chat/remove/{id}', name: 'app_chat_remove')]
    public function chatRemove(Chat $chat, EntityManagerInterface $em): Response
    {
        $messageRepository = $em->getRepository(Message::class);
        $arChatMessages = $messageRepository->findBy(['chat_id' => $chat->getId()]);

        foreach ($arChatMessages as $chatMessage) {
            $em->remove($chatMessage);
        }

        $em->remove($chat);
        $em->flush();

        return $this->redirectToRoute('app_chats_list');
    }

    #[Route('/ajax/chat-message/remove/{chatId}/{id}/', name: 'app_chat_msg_remove')]
    public function chatMsgRemove($chatId, Message $message, EntityManagerInterface $em): Response
    {
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute('app_chat', ['id'=>$chatId]);
    }
}
