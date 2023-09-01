<?php

namespace App\Controller;

use Stripe\Charge;
use Stripe\Stripe;
use App\Entity\Produits;
use App\Repository\CategorieRepository;
use App\Repository\UserRepository;
use App\Repository\PaiementRepository;
use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{

#[Route("/panier", name:"panier")]
    public function panier(
        SessionInterface $session, 
        ProduitsRepository $productsRepository,
        CategorieRepository $categorie
        )
    {
        $panier = $session->get("panier", []);
        $categories = $categorie->findAll();
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

        return $this->render('panier/panier.html.twig', compact("dataPanier","categories", "total"));

        
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

    #[Route('/stripe', name: 'stripe')]
    public function index(
        UserRepository $userRepository,
        PaiementRepository $paiement,
        CategorieRepository $categorie
    ): Response
    {
        $userRepository->findAll();
        $paiement->findAll();
        $categorie->findAll();

        return $this->render('stripe/paiement.html.twig', [
            'stripe_key' => $_ENV["STRIPE_PUBLISHABLE_KEY"],
            'categories' =>$categorie->findAll(),
        ]);
    }

    #[Route('/stripe/payment', name: 'stripe_payment', methods: ['POST'])]
    public function createCharge(
        Request $request,
        SessionInterface $session 
        ): Response
    {
        

        Stripe::setApiKey($_ENV["STRIPE_SECRET_KEY"]);
        Charge::create([
            "amount" =>  $session->get("total") * 100,
            "currency" => "EUR",
            "source" => $request->request->get('stripeToken'),
        ]);

        $this->addFlash(
            'success',
            'Payment Successful!'
        );
        return $this->redirectToRoute('stripe', [], Response::HTTP_SEE_OTHER);
    }

}
