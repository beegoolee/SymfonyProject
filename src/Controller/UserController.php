<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\WallPost;
use App\Form\ProfileEditType;
use App\Form\WallPostAddFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/users/', name: 'app_user_list')]
    public function usersList(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('user_list/index.html.twig', [
            'controller_name' => 'UserListController',
            'users' => $users,
        ]);
    }

    #[Route('/users/{id}', name: 'app_profile')]
    public function profile(User $user, Request $request, EntityManagerInterface $em): Response
    {
        $userID = $user->getId();

        $addedPost = new WallPost();
        $postAddForm = $this->createForm(WallPostAddFormType::class, $addedPost);

        $postAddForm->handleRequest($request);

        if ($postAddForm->isSubmitted() && $postAddForm->isValid()) {
            $addedPost->setPostAuthor($this->getUser());
            $addedPost->setRelatedWallOwner($user);

            $em->persist($addedPost);
            $em->flush();

            return $this->redirectToRoute('app_profile', ['id' => $userID]);
        }

        $userWallPosts = $user->getWallPosts();

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'postAddForm' => $postAddForm,
            'userWallPosts' => $userWallPosts,
        ]);
    }

    #[Route('/users/{id}/edit', name: 'app_profile_edit')]
    public function profileEdit(User $user, Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            if ($user->getId() !== $this->getUser()->getId()) {
                return $this->redirectToRoute('app_profile_edit', ['id' => $this->getUser()->getId()]);
            }
        }

        $userID = $user->getId();
        $user = $userRepository->findOneBy(['id' => $userID]);
        $form = $this->createForm(ProfileEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        }
        {
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
