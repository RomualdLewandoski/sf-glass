<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\ContactConfig;
use App\Entity\Image;
use App\Entity\MainConfig;
use App\Entity\SiteConfig;
use App\Form\ContactType;
use App\Repository\CatProductRepository;
use App\Repository\ContactConfigRepository;
use App\Repository\ContactRepository;
use App\Repository\GenderCatRepository;
use App\Repository\MainConfigRepository;
use App\Repository\SiteConfigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,
                          MainConfigRepository $mainConfigRepository,
                          ContactConfigRepository $contactRepository,
                          SiteConfigRepository $siteConfigRepository,
                          GenderCatRepository $genderCatRepository,
                          CatProductRepository $catProductRepository)
    {
        $mainConfig = $mainConfigRepository->find(1);

        if ($mainConfig == null) {
            $mainConfig = new MainConfig();

            $mainConfig->setHeaderBg(new Image());
            $mainConfig->setHeaderTitle("Title");
            $mainConfig->setHeaderSub("subTitle");

            $mainConfig->setGender1Bg(new Image());
            $mainConfig->setGender1Title("Gender1");
            $mainConfig->setGender1Slug("none");

            $mainConfig->setGender2Bg(new Image());
            $mainConfig->setGender2Title("Gender2");
            $mainConfig->setGender2Slug("none");
        }
        $contactConfig = $contactRepository->find(1);
        if ($contactConfig == null) {
            $contactConfig = new ContactConfig();
        }
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $contact->setIsRead(false);
            $contact->setIsTrash(false);
            $contact->setIsStar(false);
            $contact->setSendAt(new \DateTime('now'));
            $em->persist($contact);
            $em->flush();
        }

        $siteConfig = $siteConfigRepository->find(1);
        if ($siteConfig == null) {
            $siteConfig = new SiteConfig();
            $siteConfig->setHowWorksBg(new Image());
        }
        return $this->render('contact/index.html.twig', [
            'mainConfig' => $mainConfig,
            'genderCat' => $genderCatRepository->findAll(),
            'siteConfig' => $siteConfig,
            'contactConfig' => $contactConfig,
            'contactForm' => $form->createView(),
            'productCats' => $catProductRepository->findAll(),

            'bgWoman' => 'assets/images/background1.jpg'
        ]);
    }
}
