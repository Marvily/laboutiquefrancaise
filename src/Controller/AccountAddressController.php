<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    #[Route('/compte/adresses', name: 'account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    #[Route('/compte/ajouter-une-adresse', name: 'account_address_add')]
    public function add(Request $request, Cart $cart): Response
    {

        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if($form->isValid()){
                $address->setUser($this->getUser());
                $this->em->persist($address);
                $this->em->flush();

                if ($cart->get()){
                    return $this->redirectToRoute('order');
                }

                return $this->redirectToRoute('account_address');
            }
        }
        return $this->render('account/address_form.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/compte/modifier-une-adresse/{id}', name: 'account_address_edit')]
    public function edit(Request $request, $id): Response
    {

        $address = $this->em->getRepository(Address::class)->findOneById($id);

        if (!$address || $address->getUser()!= $this->getUser()){
            return  $this->redirectToRoute('account_address');
        }
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if($form->isValid()){
                $this->em->flush();

                return $this->redirectToRoute('account_address');
            }
        }
        return $this->render('account/address_form.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/compte/delete-une-adresse/{id}', name: 'account_address_delete')]
    public function delete(Request $request, $id): Response
    {

        $address = $this->em->getRepository(Address::class)->findOneById($id);

        if ($address || $address->getUser() == $this->getUser()){
            $this->em->remove($address);
            $this->em->flush();
        }



        return  $this->redirectToRoute('account_address');
    }
}
