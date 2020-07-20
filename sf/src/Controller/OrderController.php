<?php

namespace App\Controller;

use App\Form\OrderManagerType;
use App\Repository\OrderRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Picqer\Barcode\BarcodeGeneratorHTML;
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
     * @Route("/print/send/{id}", name="print_send")
     */
    public function printSend(OrderRepository $orderRepository, int $id)
    {
        $order = $orderRepository->find($id);
        if ($order == null) {
            return $this->redirectToRoute("order");
        }
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);

        $tracking = md5(time());
        $generator = new BarcodeGeneratorHTML();


        $html = $this->renderView('bonLivraison.html.twig', [
            'title' => "Bon de livraison",
            'order' => $order,
            'trackingNumber' => md5(time()),
            'bar' => $generator->getBarcode($tracking, $generator::TYPE_CODE_128)
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("livraison-".$order->getUser()->getNom()."-".$order->getUser()->getPrenom()."-".$tracking.".pdf", [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/print/facture/{id}", name="admin_facture")
     */
    public function adminFacture(OrderRepository $orderRepository, int $id){
        $order = $orderRepository->find($id);
        if ($order == null) {
            return $this->redirectToRoute("order");
        }
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);


        $html = $this->renderView('facture.html.Twig', [
            'title' => "Facture",
            'order' => $order,
            'livraison'=> 3.99,
            'orderProducts' => $order->getOrderProducts(),

        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("facture-".$order->getUser()->getNom()."-".$order->getUser()->getPrenom()."-".$order->getId().".pdf", [
            "Attachment" => false
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
