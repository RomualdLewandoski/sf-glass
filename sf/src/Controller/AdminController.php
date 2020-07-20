<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $userRepository, OrderRepository $orderRepository)
    {
        return $this->render('admin/pages/dashboard.html.twig', [
            'users'=>$userRepository->findAll(),
            'orders' => $orderRepository->findAll()
        ]);
    }
}
