<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Message;
use App\Form\ChatAddFormType;
use App\Form\MessageFormType;
use App\Repository\ChatRepository;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChatController extends AbstractController
{
    #[Route('/chatList/', name: 'app_chats_list')]
    public function chatList(ChatRepository $chatRepository): Response
    {
        $chats = $chatRepository->findAll();
        return $this->render('chat/chat_list.html.twig', [
            'controller_name' => 'ChatController',
            'chats' => $chats,
        ]);
    }
    #[Route('/chatList/{id}', name: 'app_chat')]
    public function chat(Chat $chat, Request $request, EntityManagerInterface $em, MessageRepository $messageRepository): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageFormType::class, $message);
        $form->handleRequest($request);

        $iChatID = $chat->getId();

        // TODO нужно в веб-форму подставить ИД чата и юзера, а также время отправки месседжа. По сути, спрашивать надо только текст сообщения

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('app_chat', ['id' => $iChatID]);
        }

        $arMessages = $messageRepository->findMessagesByChatID($iChatID);

        return $this->render('chat/chat.html.twig', [
            'controller_name' => 'ChatController',
            'messages' => $arMessages,
            'form' => $form
        ]);
    }

    #[Route('/new_chat/', name: 'app_new_chat')]
    public function newChat(Request $request, EntityManagerInterface $em): Response
    {
        $chat = new Chat();
        $form = $this->createForm(ChatAddFormType::class, $chat);
        $form->handleRequest($request);
        $chat->setOwnerId($this->getUser()->getId());

        // TODO нужно в веб-форму подставить владельца чата. По сути, спрашивать надо только имя чата и кого добавляем в него
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($chat);
            $em->flush();

            return $this->redirectToRoute('app_chat', ['id' => $chat->getId()]);
        }

        return $this->render('chat/new_chat.html.twig', [
            'controller_name' => 'ChatController',
            'form' => $form,
        ]);
    }
}
