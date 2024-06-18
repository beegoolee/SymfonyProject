<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileEditType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function profile(User $user): Response
    {
        $userID = $user->getId();

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
        ]);
    }

    #[Route('/profile/{id}/edit', name: 'app_profile_edit')]
    public function profileEdit(User $user, Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }else{
            if($user->getId() !== $this->getUser()->getId()){
                return $this->redirectToRoute('app_profile_edit', ['id' => $this->getUser()->getId()]);
            }
        }

        $userID = $user->getId();
        $user = $userRepository->findOneBy(['id' => $userID]);
        $form = $this->createForm(ProfileEditType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){} {
            $em->persist($user);
            $em->flush();
        }

        return $this->render('profile/edit.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'form' => $form,
        ]);
    }
}
