<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ManController extends AbstractController
{
    /**
     * @Route("/man", name="man")
     */
    public function index()
    {
        return $this->render('man/index.html.twig', [
            'imgUrl' => 'assets/images/01.jpg',
            'bgMan' => 'assets/images/background2.jpg',
            'bgWoman' => 'assets/images/background1.jpg'
        ]);
    }
}
