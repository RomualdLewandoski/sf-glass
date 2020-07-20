<?php

namespace App\Controller;

use App\Form\OrderManagerType;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="order")
     */
    public function index(OrderRepository $orderRepository)
    {
        return $this->render('admin/pages/order/orderList.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/manage/{id}", name="order_manage")
     */
    public function manageOrder(Request $request, OrderRepository $orderRepository, int $id)
    {
        $order = $orderRepository->find($id);
        if ($order == null) {
            return $this->redirectToRoute("order");
        }
        $orderProducts = $order->getOrderProducts();
        $form = $this->createForm(OrderManagerType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('admin/pages/order/orderManger.html.twig', [
            'order' => $order,
            'livraison' => 3.99,
            'orderProducts' => $orderProducts,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/api/order/pending", name="api_pending_order")
     */
    public function getPendingOrder(OrderRepository $orderRepository)
    {
        $obj = new \stdClass();
        $orders = $orderRepository->findBy(['status' => 0]);
        $obj->count = count($orders);
        return new JsonResponse($obj);
    }


}
