<?php

namespace App\Controller;

use App\Entity\GenderCat;
use App\Entity\Product;
use App\Form\GenderCatType;
use App\Repository\GenderCatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class GenderCatController extends AbstractController
{
    /**
     * @Route("/admin/gender", name="gender_cat_index", methods={"GET"})
     */
    public function index(GenderCatRepository $genderCatRepository): Response
    {
        return $this->render('admin/pages/gender/genderList.html.twig', [
            'gender_cats' => $genderCatRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/gender/new", name="gender_cat_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $genderCat = new GenderCat();
        $form = $this->createForm(GenderCatType::class, $genderCat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($genderCat);
            $entityManager->flush();

            return $this->redirectToRoute('gender_cat_index');
        }

        return $this->render('admin/pages/gender/newGender.html.twig', [
            'gender_cat' => $genderCat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/gender/{id}", name="gender_cat_show", methods={"GET"})
     */
    public function show(GenderCat $genderCat): Response
    {
        return $this->render('admin/pages/gender/showGender.html.twig', [
            'gender_cat' => $genderCat,
        ]);
    }

    /**
     * @Route("/admin/gender/{id}/edit", name="gender_cat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GenderCat $genderCat): Response
    {
        $form = $this->createForm(GenderCatType::class, $genderCat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gender_cat_index');
        }

        return $this->render('admin/pages/gender/editGender.html.twig', [
            'gender_cat' => $genderCat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/gender/{id}", name="gender_cat_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GenderCat $genderCat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$genderCat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($genderCat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gender_cat_index');
    }
}
