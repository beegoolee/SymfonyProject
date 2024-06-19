<?php

namespace App\Controller\Ajax;

use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\WallPost;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AjaxWallPostController extends AbstractController
{
    #[Route('/ajax/wallpost/remove/{wallOwnerID}/{id}/', name: 'app_wallpost_remove')]
    public function wallpostRemove($wallOwnerID, WallPost $wallPost, EntityManagerInterface $em): Response
    {
        $em->remove($wallPost);
        $em->flush();

        return $this->redirectToRoute('app_profile', ['id' => $wallOwnerID]);
    }
}
