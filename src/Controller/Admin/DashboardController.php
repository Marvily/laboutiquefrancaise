<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('La Boutique Française');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
         yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
         yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
         yield MenuItem::linkToCrud('Products', 'fas fa-tag', Product::class);
         yield MenuItem::linkToCrud('Carrier', 'fas fa-truck', Carrier::class);
         yield MenuItem::linkToUrl('home', 'fas fa-home', $this->generateUrl('home'));
    }
}
