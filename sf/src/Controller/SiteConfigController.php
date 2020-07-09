<?php

namespace App\Controller;

use App\Entity\SiteConfig;
use App\Form\SiteConfigType;
use App\Repository\SiteConfigRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteConfigController extends AbstractController
{
    /**
     * @Route("/admin/config/new", name="site_config_new", methods={"GET","POST"})
     */
    public function new(Request $request, SiteConfigRepository $siteConfigRepository): Response
    {

        $siteConfig = $siteConfigRepository->find(1);
        if ($siteConfig == null) {
            $siteConfig = new SiteConfig();
            $form = $this->createForm(SiteConfigType::class, $siteConfig);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($siteConfig);
                $entityManager->flush();

                return $this->redirectToRoute('site_config_show');
            }

            return $this->render('admin/pages/config/newConfig.html.twig', [
                'site_config' => $siteConfig,
                'form' => $form->createView(),
            ]);
        }else{
            return $this->redirectToRoute('site_config_edit');
        }
    }

    /**
     * @Route("/admin/config", name="site_config_show", methods={"GET"})
     */
    public function show(SiteConfigRepository $siteConfigRepository): Response
    {
        $siteConfig = $siteConfigRepository->find(1);
        if ($siteConfig == null){
            return $this->redirectToRoute('site_config_new');
        }else{
            return $this->redirectToRoute('site_config_edit');

        }
    }

    /**
     * @Route("admin/config/edit/", name="site_config_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SiteConfigRepository $siteConfigRepository): Response
    {
        $siteConfig = $siteConfigRepository->find(1);
        if ($siteConfig == null){
            return $this->redirectToRoute('site_config_new');
        }
        $form = $this->createForm(SiteConfigType::class, $siteConfig);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('site_config_show');
        }

        return $this->render('admin/pages/config/editConfig.html.twig', [
            'site_config' => $siteConfig,
            'form' => $form->createView(),
        ]);
    }
}
