<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
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
