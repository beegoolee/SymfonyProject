<?php

namespace App\Controller\Ajax;

use App\Entity\Chat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AjaxChatController extends AbstractController
{
    #[Route('/ajax/chat/remove/{id}', name: 'app_chat_ajax')]
    public function index(Chat $chat, EntityManagerInterface $em): Response
    {
        // TODO: вместе с удалением чата нужно удалять и сообщения из него
        $em->remove($chat);
        $em->flush();

        return $this->redirectToRoute('app_chats_list');
    }
}
