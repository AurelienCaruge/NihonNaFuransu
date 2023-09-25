<?php

namespace App\Controller\Admin;

use Stripe\Stripe;
use App\Entity\Produits;
use App\Entity\Categorie;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\PaiementRepository;
use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    
        private PaiementRepository $paiementRepository;
        private ProduitsRepository $produitsRepository;
        private ChartBuilderInterface $chartBuilder;
        // private Request $request;
        // private SessionInterface $session;

    public function __construct(
        ChartBuilderInterface $chartBuilder,
        PaiementRepository $paiementRepository,
        ProduitsRepository $produitsRepository,
        // Request $request,
        // SessionInterface $session
    ) {
        $this->paiementRepository = $paiementRepository;
        $this->produitsRepository = $produitsRepository;
        $this->chartBuilder = $chartBuilder;
        // $this->session = $session;
        // $this->request = $request;

    }

    private function createChart(): Chart{

        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            
        ]);
        return $chart;

    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $paiementRepository = $this->paiementRepository;
        $produitsRepository = $this->produitsRepository;
        
        // $session = $this->session;

        // $panier = $session->get("panier", []);

        // $dataPanier = [];

        // $total = 0;

        // foreach($panier as $id => $quantite){

        //     $product = $produitsRepository->find($id);

        //     $dataPanier[] = [

        //         "produit" => $produitsRepository,

        //         "quantite" => $quantite

        //     ];

        //     $total += $product->getPrix() * $quantite;

        // }
        
        Stripe::setApiKey($_ENV["STRIPE_SECRET_KEY"]);

// if (
//     $this->addFlash(

//         'success',

//         'Payment Successful!'

//     ) == true
// ) {
//     $produitsRepository->findBy('nom');
//     $paiementRepository->findBy('montant');
// }

        


        return $this->render('admin/dashboard.html.twig', [
            'chart' => $this->createChart(),
            'paiement' => $paiementRepository,
            'produits' => $produitsRepository,
            'stripe', 
        ],);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('NihonNaFuransu');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Categorie', 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-dollar', Produits::class);
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-arrow-left', 'accueil');
    }
}
