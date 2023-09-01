<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(
        CategorieRepository $categorie,
    ): Response
    {
        return $this->render('homepage/accueil.html.twig', [
            'controller_name' => 'HomepageController',
            'categories' => $categorie->findAll(),
        ]);
    }
}
