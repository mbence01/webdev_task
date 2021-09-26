<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/orders", name="orders")
     */
    public function index(OrderRepository $orderRepo): Response
    {
        return $this->render('order/orders.html.twig', [
            'orders' => $orderRepo->getRowsDesc()
        ]);
    }
}
