<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request)
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            dump($contact);
            $contact->setIsRead(false);
            $contact->setIsTrash(false);
            $em->persist($contact);
            $em->flush();
        }

        return $this->render('main/index.html.twig', [
            'imgUrl' => 'assets/images/01.jpg',
            'bgMan' => 'assets/images/background2.jpg',
            'bgWoman' => 'assets/images/background1.jpg',
            'contactForm' => $form->createView()
        ]);
    }

}
