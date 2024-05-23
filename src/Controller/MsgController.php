<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MsgController extends AbstractController
{
    #[Route('/msg/', 'Messenger')]
    public function index(){
        return $this->render('msg/msg.html.twig');
    }
}