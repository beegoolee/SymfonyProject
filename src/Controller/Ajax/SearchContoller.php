<?php

namespace App\Controller\Ajax;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SearchContoller extends AbstractController
{
    #[Route('/ajax/search-suggestions/', 'Ajax search suggestions')]
    public function searchSuggestions(){
        return $this->json(['PRODUCTS' => ['322', '233']]);
    }
}