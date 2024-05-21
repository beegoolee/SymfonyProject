<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog/', 'Catalog main')]
    public function catalogMain(){
        return $this->render('catalog/catalog_main.html.twig');
    }

    #[Route('/catalog/{section_code}', 'Catalog section')]
    public function catalogSection($section_code){
        $someText = ['qwe', 'afawfaw', 'awfg23c1f'];

        return $this->render('catalog/catalog_section.html.twig', [
            'section' => $section_code,
            'some_text' => $someText
        ]);
    }
}