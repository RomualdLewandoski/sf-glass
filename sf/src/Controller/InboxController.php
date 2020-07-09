<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InboxController extends AbstractController
{
    /**
     * @Route("/inbox", name="inbox")
     */
    public function index()
    {
        return $this->render('inbox/index.html.twig', [
            'controller_name' => 'InboxController',
        ]);
    }
}
