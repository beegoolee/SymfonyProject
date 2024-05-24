<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog/', 'Catalog root')]
    public function catalogIndexPage(){
        return $this->render('catalog/catalog_list.html.twig');
    }

    #[Route('/catalog/{section_path}', 'Catalog section')]
    public function catalogSectionPage($section_path){
        return $this->render('catalog/catalog_list.html.twig');
    }

    #[Route('/catalog/{section_path}/{product_code}', 'Product detail')]
    public function catalogProductDetailPage($section_path, $product_code){
        return $this->render('catalog/product_detail.html.twig');
    }
}