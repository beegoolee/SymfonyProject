<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainpageController extends AbstractController
{
    #[Route('/', 'Site mainpage')]
    public function index(){
        return $this->render('mainpage.html.twig');
    }
}