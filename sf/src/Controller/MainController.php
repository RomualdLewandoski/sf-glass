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
use App\Repository\FeaturesRepository;
use App\Repository\GenderCatRepository;
use App\Repository\MainConfigRepository;
use App\Repository\PartnersRepository;
use App\Repository\ProductRepository;
use App\Repository\SiteConfigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(Request $request,
                          ProductRepository $productRepository,
                          GenderCatRepository $genderCatRepository,
                          MainConfigRepository $mainConfigRepository,
                          ContactConfigRepository $contactRepository,
                          SiteConfigRepository $siteConfigRepository,
                          PartnersRepository $partnersRepository,
                          FeaturesRepository $featuresRepository,
                          CatProductRepository $catProductRepository
    )
    {

        $mainConfig = $mainConfigRepository->find(1);
        $contactConfig = $contactRepository->find(1);
        $siteConfig = $siteConfigRepository->find(1);
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
        if ($contactConfig == null) {
            $contactConfig = new ContactConfig();
        }
        if ($siteConfig == null) {
            $siteConfig = new SiteConfig();
            $siteConfig->setHowWorksBg(new Image());
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

        $sponsoProducts = $productRepository->getSponsoAllGenre();
        if ($sponsoProducts == null) {
            $sponsoProducts = $productRepository->getLatest();
        }

        return $this->render('main/index.html.twig', [
            'mainConfig' => $mainConfig,
            'contactConfig' => $contactConfig,
            'siteConfig' => $siteConfig,
            'partners' => $partnersRepository->findAll(),
            'features' => $featuresRepository->getLatest(),
            'imgUrl' => 'assets/images/01.jpg',
            'bgMan' => 'assets/images/background2.jpg',
            'bgWoman' => 'assets/images/background1.jpg',
            'sponsoProducts' => $sponsoProducts,
            'genderCat' => $genderCatRepository->findAll(),
            'contactForm' => $form->createView(),
            'productCats' => $catProductRepository->findAll()
        ]);
    }

    /**
     * @Route("/gender/{slug}", name="view_gender")
     */
    public function viewGender(Request $request,
                               ProductRepository $productRepository,
                               MainConfigRepository $mainConfigRepository,
                               GenderCatRepository $genderCatRepository,
                               string $slug,
                               SiteConfigRepository $siteConfigRepository,
                               PartnersRepository $partnersRepository,
                               CatProductRepository $catProductRepository

    )
    {

        $siteConfig = $siteConfigRepository->find(1);
        $mainConfig = $mainConfigRepository->find(1);
        $gender = $genderCatRepository->findOneBy(["slug" => $slug]);
        if ($gender == null) {
            return $this->redirectToRoute("main");
        }

        if ($siteConfig == null) {
            $siteConfig = new SiteConfig();
            $siteConfig->setHowWorksBg(new Image());
        }
        $sponsoProducts = $productRepository->getSponsoByGender($gender->getId());

        if ($sponsoProducts == null) {
            $sponsoProducts = $productRepository->getLatestGender($gender->getId());
        }

        return $this->render('genderView/index.html.twig', [
            'sponsoProducts' => $sponsoProducts,
            'mainConfig' => $mainConfig,
            'partners' => $partnersRepository->findAll(),
            'genderCat' => $genderCatRepository->findAll(),
            'siteConfig' => $siteConfig,
            'headerBg' => $gender->getHeaderBg(),
            'productCats' => $catProductRepository->findAll()
        ]);
    }


}
