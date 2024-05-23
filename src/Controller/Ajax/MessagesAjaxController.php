<?php

namespace App\Controller\Ajax;

use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagesAjaxController extends AbstractController
{
    #[Route('/ajax/msg/add/{chatid<\d+>}/', 'Add message', methods: ['POST', 'GET'])]
    public function ajaxAddMsg($chatid, LoggerInterface $logger){
        $arChatMessages = [];
//        $arChatMessages[] = $_POST['MSG_TEXT'];
        $logger->info("added message");
        return $this->json(['CHAT_MSGS' => $arChatMessages]);
    }

    #[Route('/ajax/msg/delete/', 'Delete message', methods: ['POST', 'GET'])]
    public function ajaxDeleteMsg(){
        $arChatMessages = [];

        return $this->json(['CHAT_MSGS' => $arChatMessages]);
    }
}