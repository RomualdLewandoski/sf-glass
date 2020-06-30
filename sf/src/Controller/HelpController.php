<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelpController extends AbstractController
{
    /**
     * @Route("/help", name="help")
     */
    public function index()
    {
        return $this->render('help/index.html.twig', [
            'imgUrl' => 'assets/images/01.jpg',
            'bgMan' => 'assets/images/background2.jpg',
            'bgWoman' => 'assets/images/background1.jpg'
        ]);
    }
}
