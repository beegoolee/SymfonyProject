<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainpageController
{
    #[Route('/', 'mainpage controller')]
    public static function index(){
        return new Response("TEST");
    }

    #[Route('/catalog/{slug}', 'catalog details controller')]
    public static function detail($slug)
    {
        return new Response("Деталка от символьного кода: ". $slug);
    }
}