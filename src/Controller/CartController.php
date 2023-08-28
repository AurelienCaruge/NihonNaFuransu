<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

#[Route("/panier", name:"panier")]
    public function panier(SessionInterface $session, ProduitsRepository $productsRepository)
    {
        $panier = $session->get("panier", []);

        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $product = $productsRepository->find($id);
            $dataPanier[] = [
                "produit" => $product,
                "quantite" => $quantite
            ];
            $total += $product->getPrix() * $quantite;
        }

        return $this->render('panier/panier.html.twig', compact("dataPanier", "total"));
    }


#[Route("/add/{id}", name:"panier_add")]
    public function add(Produits $product, SessionInterface $session)
    {
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("panier");
    }


#[Route("/remove/{id}", name:"panier_remove")]
    public function remove(Produits $product, SessionInterface $session)
    {
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("panier");
    }


#[Route("/delete/{id}", name:"panier_delete")]
    public function delete(Produits $product, SessionInterface $session)
    {
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set("panier", $panier);

        return $this->redirectToRoute("panier");
    }


#[Route("/delete", name:"delete_all")]
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("panier");
    }

}
