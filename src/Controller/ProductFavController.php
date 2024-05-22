<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductFavController extends AbstractController
{
    /**
     * @param string $product_id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/product-fav/{product_id<\d+>}', 'toggle-product-fav', methods: ['POST', 'GET'])]
    public function toggleFavProduct($product_id)
    {

        return $this->json(['success' => true, 'kostya'=>'molodec','product_id' => $product_id]);
    }
}