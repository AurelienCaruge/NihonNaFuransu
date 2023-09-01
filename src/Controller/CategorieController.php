<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie/{id}', name: 'categorie')]
    public function index(
        CategorieRepository $categorie,
        $id
    ): Response
    {
        $cat = $categorie->find($id);
        return $this->render('categorie/index.html.twig',[
            'controller_name' => 'CategorieController',
            'categories' =>$categorie->findAll(),
            'categorie' => $cat,
            'produits' => $cat->getProduits(),
        ]);
    }
}
