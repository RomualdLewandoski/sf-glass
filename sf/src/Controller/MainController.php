<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'imgUrl' => 'assets/images/01.jpg',
            'bgMan' => 'assets/images/background2.jpg',
            'bgWoman' => 'assets/images/background1.jpg'
        ]);
    }

    /**
     * @Route("/woman", name="woman")
     */
    public function woman(){

    }

    /**
     * @Route("/man", name="man")
     */
    public function man(){

    }
}
