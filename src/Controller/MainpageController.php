<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainpageController extends AbstractController
{
    #[Route('/', 'Mainpage')]
    public function index(EntityManagerInterface $em){
        $repo = $em->getRepository(Product::class);
        $arProducts = $repo->findAll();

        return $this->render('mainpage.html.twig',
            [
                'products_discounted' => $arProducts,
                'products_of_the_day' => $arProducts,
            ]
        );
    }
}