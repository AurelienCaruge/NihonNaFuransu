<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use App\Repository\ProduitsRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecettesController extends AbstractController
{
    #[Route('/recettes', name: 'recettes')]
    public function index(
        CategorieRepository $categorie,
        RecetteRepository $recette,
    ): Response
    {
        return $this->render('recettes/recettes.html.twig', [
            'controller_name' => 'RecettesController',
            'categories' => $categorie->findAll(),
            'recettes' => $recette->findAll(),
        ]);
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
