<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\MainConfig;
use App\Entity\SiteConfig;
use App\Repository\CatProductRepository;
use App\Repository\GenderCatRepository;
use App\Repository\MainConfigRepository;
use App\Repository\PartnersRepository;
use App\Repository\SiteConfigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelpController extends AbstractController
{
    /**
     * @Route("/help", name="help")
     */
    public function index(SiteConfigRepository $siteConfigRepository,
                          PartnersRepository $partnersRepository,
                          MainConfigRepository $mainConfigRepository,
                          GenderCatRepository $genderCatRepository,
                          CatProductRepository $catProductRepository)
    {
        $siteConfig = $siteConfigRepository->find(1);
        if ($siteConfig == null) {
            $siteConfig = new SiteConfig();
            $siteConfig->setHowWorksBg(new Image());
        }
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

        return $this->render('help/index.html.twig', [
            'mainConfig' => $mainConfig,
            'genderCat' => $genderCatRepository->findAll(),
            'siteConfig' => $siteConfig,
            'productCats' => $catProductRepository->findAll(),
            'partners' => $partnersRepository->findAll(),

        ]);
    }
}
