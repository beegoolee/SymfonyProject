<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainpageController extends AbstractController
{
    #[Route('/', 'Mainpage')]
    public function index(){
        return $this->render('mainpage.html.twig');
    }
}