<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'categorie')]
    public function index(
        ProduitsRepository $produits,
        CategorieRepository $categorie,
    ): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'categorie' => $categorie->findAll(),
            'produits' => $produits->findBy(
                [],
                ['id' => 'ASC']
                ),
        ]);
    }
}
