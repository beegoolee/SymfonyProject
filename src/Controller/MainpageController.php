<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainpageController extends AbstractController
{
    #[Route('/', name: 'app_mainpage')]
    public function mainpage(): Response
    {
        $user = $this->getUser();
        return $this->render('mainpage.html.twig', [
            'controller_name' => 'MainpageController',
            'user' => $user,
        ]);
    }
}
