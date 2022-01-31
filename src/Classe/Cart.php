<?php

namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{

    private $session;
    private $em;

    public function __construct(SessionInterface $session, EntityManagerInterface $em){
        $this->session = $session;
        $this->em = $em;
    }

    public function add($id){
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);

    }

    public function get(){
        return $this->session->get('cart');
    }
    public function getFull(){

        $cartComplete = [];
        if ($this->get()){
            foreach ($this->get() as $id => $quantity){
                $productObject = $this->em->getRepository(Product::class)->findOneById($id);
                if (!$productObject){
                    $this->delete($id);
                    continue;
                }
                $cartComplete[]= [
                    'product'=> $productObject,
                    'quantity'=>$quantity
                ];

            }
        }
        return $cartComplete;
    }

    public function remove(){

        return $this->session->remove('cart');
    }

    public function delete($id){

        $cart = $this->session->get('cart', []);

        unset($cart[$id]);
        return $this->session->set('cart', $cart);
    }

    public function decrease($id){

        $cart = $this->session->get('cart', []);

        if ($cart[$id] > 1){// retire la quantité
            $cart[$id] --;
        }else{// supprime le produit
            unset($cart[$id]);
        }
        return $this->session->set('cart', $cart);
    }

}