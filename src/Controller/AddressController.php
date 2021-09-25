<?php

namespace App\Controller;

use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AddressController extends AbstractController
{
    /**
     * @Route("/address", name="address")
     */
    public function index(Environment $env, AddressRepository $addrRepo): Response
    {
        //$form = $this->createFormBuilder(new Task())
          //              ->add("Task", TextType::class)
            //            ->add("Save", SubmitType::class, ["label" => "Create Task"])
              //          ->getForm();

        return new Response($env->render(
            'address/address.html.twig', [
                'addresses' => $addrRepo->findAll(),
            ]
        ));
    }
}
