<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\User;
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
    /**
     * @param ChatRepository $chatRepository
     * @return Response
     *
     * Контроллер списка чатов
     */
    #[Route('/chatList/', name: 'app_chats_list')]
    public function chatList(ChatRepository $chatRepository): Response
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('app_login');
        }

        $chats = $user->getChats();

        return $this->render('chat/chat_list.html.twig', [
            'controller_name' => 'ChatController',
            'chats' => $chats,
        ]);
    }

    /**
     * @param Chat $chat
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param MessageRepository $messageRepository
     * @return Response
     *
     * Контроллер конкретных чатов
     */
    #[Route('/chatList/{id}', name: 'app_chat')]
    public function chat(Chat $chat, Request $request, EntityManagerInterface $em, MessageRepository $messageRepository): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $message = new Message();
        $form = $this->createForm(MessageFormType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setAuthor($this->getUser());
            $message->setChat($chat);

            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('app_chat', ['id' => $chat->getId()]);
        }

        return $this->render('chat/chat.html.twig', [
            'controller_name' => 'ChatController',
            'form' => $form,
            'chat' => $chat
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     *
     * Контроллер добавления нового чата
     */
    #[Route('/new_chat/', name: 'app_new_chat')]
    public function newChat(Request $request, EntityManagerInterface $em): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $chat = new Chat();
        $form = $this->createForm(ChatAddFormType::class, $chat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $chat->setChatOwner($user);
            $chat->addMember($user);
            $chat->setPrivate(false);
            $em->persist($chat);

            $user->addChat($chat);
            $em->persist($user);

            $em->flush();

            return $this->redirectToRoute('app_chat', ['id' => $chat->getId()]);
        }

        return $this->render('chat/new_chat.html.twig', [
            'controller_name' => 'ChatController',
            'form' => $form,
        ]);
    }
}
