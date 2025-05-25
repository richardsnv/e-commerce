<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/admin/user/{id}/to/editor', name: 'app_user_to_editor')]

    public function changeRole(EntityManagerInterface $entityManagerInterface, User $user): Response
    {
        $user->setRoles(["ROLE_EDITOR", "ROLE_USER"]);
        $entityManagerInterface->flush();
        $this->addFlash('success', 'le role editor a ete ajoute a votre utilisateur');
        return $this->redirectToRoute('app_user');
    }

     #[Route('/admin/user/{id}/remove/to/editor/role', name: 'app_user_to_editor_role')]

    public function editorRemove(EntityManagerInterface $entityManagerInterface, User $user): Response
    {
        $user->setRoles([]);
        $entityManagerInterface->flush();
        $this->addFlash('danger', 'le role editor a ete retire a votre utilisateur');
        return $this->redirectToRoute('app_user');
    }

    #[Route('/admin/user/{id}/remove/', name: 'app_user_remove')]
    public function userRemove(EntityManagerInterface $entityManagerInterface, $id,UserRepository $userRepository): Response
    {
        $userFind=$userRepository->find($id);
        $entityManagerInterface->remove($userFind);
        $entityManagerInterface->flush();
        $this->addFlash('danger', ' votre utilisateur a bien ete supprimer');
        return $this->redirectToRoute('app_user');
    }
}
