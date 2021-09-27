<?php

namespace App\Controller;

use App\Entity\Address;
use App\Repository\AddressRepository;
use App\Form\AddressFormType;
use App\Form\EditAddressFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AddressController extends AbstractController
{
    private $entityManager;
    private $env;

    public function __construct(Environment $env, EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->env = $env;
    }

    /**
     * @Route("/deleteaddr/{id}", name="deleteaddr")
     */
    public function deleteAddress($id, Request $req, AddressRepository $addrRepo): Response
    {
        $obj = $addrRepo->findBy(["id" => $id])[0];

        $this->entityManager->remove($obj);
        $this->entityManager->flush();

        return $this->redirectToRoute("address", ["success" => 1, "page" => "deladdr"]);
    }

    /**
     * @Route("/address/{id}", defaults={"id" = 0}, name="address")
     */
    public function index($id, Request $req, AddressRepository $addrRepo): Response
    {
        $form = null;
        $addr = null;
        $page = null;
        $pageTitle = "";

        if($id == 0) {
            $addr = new Address();
            $form = $this->createForm(AddressFormType::class, $addr);
            $page = "addaddr";
            $pageTitle = "Új számlázási cím létrehozása:";
        } else {
            $addr = $addrRepo->findBy(["id" => $id])[0];
            $form = $this->createForm(EditAddressFormType::class, $addr);
            $page = "editaddr";
            $pageTitle = "Számlázási cím módosítása";
        }

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $arr = $form->getData();

            $fieldLeftEmpty =    
                empty($arr->getName())     ||
                empty($arr->getCountry())  ||
                empty($arr->getPostCode()) ||
                empty($arr->getCity())     ||
                empty($arr->getAddress());

            if($fieldLeftEmpty) {
                return $this->redirectToRoute('address', ["success" => 0, "err" => "fd"]);
            }

            if($arr->getType() == 0 && empty($arr->getTaxnumber())) {
                return $this->redirectToRoute('address', ["success" => 0, "err" => "te"]);
            }

            if(preg_match("/^[0-9]{4,}$/", $arr->getPostCode()) != 1) {
                return $this->redirectToRoute('address', ["success" => 0, "err" => "pc"]);
            }

            if(!empty($arr->getPhonenumber()) && preg_match("/^\+{1}36[0-9]{8,9}$/", $arr->getPhonenumber()) != 1) {
                return $this->redirectToRoute('address', ["success" => 0, "err" => "ph"]);
            }

            if(!empty($arr->getTaxnumber()) && preg_match("/^[0-9]{8}-[1-5]-[0-9]{2}$/", $arr->getTaxnumber()) != 1) {
                return $this->redirectToRoute('address', ["success" => 0, "err" => "tx"]);
            }

            $this->entityManager->persist($addr);
            $this->entityManager->flush();

            return $this->redirectToRoute('address', ["success" => 1, "page" => $page]);
        }

        return new Response($this->env->render(
            'address/address.html.twig', [
                'addresses' => $addrRepo->findAll(),
                'newAddressForm' => $form->createView(),
                'pageTitle' => $pageTitle
            ]
        ));
    }
}
