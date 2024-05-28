<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Cart;
use App\Entity\Shop;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $adminUrlGenerator;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(ShopCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('FastCheakout Dashboard');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::subMenu('Gestion', 'fa fa-home')->setSubItems([
            MenuItem::linkToCrud('Magasin', 'fa fa-home', Shop::class),
            MenuItem::linkToCrud('Article', 'fa fa-book', Article::class),
            MenuItem::linkToCrud('Panier', 'fa fa-book', Cart::class),
        ]);

        yield MenuItem::subMenu('Administration', 'fa fa-user')->setSubItems([
            MenuItem::linkToCrud('User', 'fa fa-user', User::class),
        ]);
    }
}
