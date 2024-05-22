<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/catalog/', 'Catalog main')]
    public function catalogMain(){
        return $this->render('catalog/catalog_main.html.twig');
    }

    /**
     * @param $section_code
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/catalog/{section_code}', 'Catalog section')]
    public function catalogSection($section_code,  loggerInterface $logger){
        $someText = ['qwe', 'afawfaw', 'awfg23c1f'];

        $logger->info(sprintf('Opened section with code %s', $section_code));

        return $this->render('catalog/catalog_section.html.twig', [
            'section' => $section_code,
            'some_text' => $someText
        ]);
    }
}