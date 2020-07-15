<?php

namespace App\Controller;

use App\Entity\ContactConfig;
use App\Entity\MainConfig;
use App\Entity\SiteConfig;
use App\Form\ContactConfigType;
use App\Form\MainConfigType;
use App\Form\SiteConfigType;
use App\Repository\ContactConfigRepository;
use App\Repository\ImageRepository;
use App\Repository\MainConfigRepository;
use App\Repository\SiteConfigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteConfigController extends AbstractController
{

    /**
     * @Route("admin/config/main", name="main_config", methods={"GET", "POST"})
     */
    public function mainConfig(Request $request, MainConfigRepository $mainConfigRepository, ImageRepository $imageRepository): Response
    {
        $mainConfig = $mainConfigRepository->find(1);
        $em = $this->getDoctrine()->getManager();
        if ($mainConfig == null) {
            $config = new MainConfig();
            $form = $this->createForm(MainConfigType::class, $config);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($config);
                $em->flush();
                return $this->redirectToRoute("main_config");
            }
            return $this->render('admin/pages/config/newConfig.html.twig', [
                'images' => $imageRepository->findAll(),
                'main_config' => $mainConfig,
                'form' => $form->createView(),
            ]);
        } else {
            $form = $this->createForm(MainConfigType::class, $mainConfig);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                return $this->redirectToRoute("main_config");
            }
            return $this->render('admin/pages/config/newConfig.html.twig', [
                'images' => $imageRepository->findAll(),
                'form' => $form->createView(),
            ]);
        }
    }

    /**
     * @Route("/admin/config/contact", name="contact_config", methods={"GET", "POST"})
     */
    public function contactConfig(Request $request, ContactConfigRepository $contactConfigRepository, ImageRepository $imageRepository): Response
    {
        $contactConfig = $contactConfigRepository->find(1);
        $em = $this->getDoctrine()->getManager();
        if ($contactConfig == null) {
            $config = new ContactConfig();
            $form = $this->createForm(ContactConfigType::class, $config);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($config);
                $em->flush();
                return $this->redirectToRoute("contact_config");
            }
            return $this->render('admin/pages/config/newConfig.html.twig', [
                'images' => $imageRepository->findAll(),
                'form' => $form->createView(),
            ]);
        } else {
            $form = $this->createForm(ContactConfigType::class, $contactConfig);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                return $this->redirectToRoute("contact_config");
            }
            return $this->render('admin/pages/config/newConfig.html.twig', [
                'images' => $imageRepository->findAll(),
                'form' => $form->createView(),
            ]);
        }
    }


    /**
     * @Route("/admin/config/site", name="site_config_show", methods={"GET", "POST"})
     */
    public function show(Request $request, SiteConfigRepository $siteConfigRepository, ImageRepository $imageRepository): Response
    {
        $siteConfig = $siteConfigRepository->find(1);
        $em = $this->getDoctrine()->getManager();

        if ($siteConfig == null) {
            $config = new SiteConfig();
            $form = $this->createForm(SiteConfigType::class, $config);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($config);
                $em->flush();
                return $this->redirectToRoute("site_config_show");
            }
            return $this->render('admin/pages/config/newConfig.html.twig', [
                'images' => $imageRepository->findAll(),
                'form' => $form->createView(),
            ]);
        } else {
            $form = $this->createForm(SiteConfigType::class, $siteConfig);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                return $this->redirectToRoute("site_config_show");
            }
            return $this->render('admin/pages/config/newConfig.html.twig', [
                'images' => $imageRepository->findAll(),
                'form' => $form->createView(),
            ]);
        }
    }

}
