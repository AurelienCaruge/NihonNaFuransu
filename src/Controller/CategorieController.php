<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
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

    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public function someMethod()
    {
        $url = $this->adminUrlGenerator->setRoute('admin_business_stats_customer', [
            'id' => $this->getUser(),
        ])->generateUrl();

        return $this->redirect($url);
    }
}
