<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FriendsController extends AbstractController
{
    #[Route('/friends/', 'Friends list')]
    public function index(){
        return $this->render('friends/friends.html.twig');
    }
}