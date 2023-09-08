<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, ProduitsRepository $produits, CategorieRepository $categorie, Request $request): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $id = $request->get('id');
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'categories' => $categorie->findAll(), 'produits' => $produits->findOneBy(
            ['id' => $id]
            )]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/{id}', name: 'vue')]
    public function vue(
        ProduitsRepository $produits,
        CategorieRepository $categorie,
        Request $request
    ): Response
    {
        $id = $request->get('id');
        return $this->render('categorie/vue.html.twig',[
            'categories' =>$categorie->findAll(),
            'produits' => $produits->findOneBy(
                ['id' => $id]
                )
        ]);
    }
}
