<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductAddController extends AbstractController
{
    #[Route('/product/add/{name}/{price}/', name: 'app_product_add')]
    public function index(EntityManagerInterface $em, $name, $price): Response
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $product->setImage("img/product.jpg");

        $em->persist($product);
        $em->flush();

        return $this->json(['success' => true]);
    }
}
