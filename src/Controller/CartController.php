<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
//        $cartComplete = [];
//        if ($cart->get()){
//            foreach ($cart->get() as $id => $quantity){
//                $cartComplete[]= [
//                    'product'=>$this->em->getRepository(Product::class)->findOneById($id) ,
//                    'quantity'=>$quantity
//                ];
//
//            }
//        }

        return $this->render('cart/index.html.twig', [
//            'cart' => $cartComplete,
            'cart' => $cart->getFull(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add($id, Cart $cart): Response
    {
        $cart->add($id);

        return  $this->redirectToRoute('cart');

    }
    #[Route('/cart/remove', name: 'remove_my_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return  $this->redirectToRoute('products');

    }

    #[Route('/cart/delete/{id}', name: 'delete_to_cart')]
    public function delete(Cart $cart ,$id): Response
    {
        $cart->delete($id);

        return  $this->redirectToRoute('cart');

    }
    #[Route('/cart/decrease/{id}', name: 'decrease_to_cart')]
    public function decrease(Cart $cart ,$id): Response
    {
        $cart->decrease($id);

        return  $this->redirectToRoute('cart');

    }
}
