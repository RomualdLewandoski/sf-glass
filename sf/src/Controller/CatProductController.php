<?php

namespace App\Controller;

use App\Entity\CatProduct;
use App\Form\CatProductType;
use App\Repository\CatProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatProductController extends AbstractController
{
    /**
     * @Route("/admin/cat/product", name="cat_product_index", methods={"GET"})
     */
    public function index(CatProductRepository $catProductRepository): Response
    {
        return $this->render('admin/pages/catProduct/listCat.html.twig', [
            'cat_products' => $catProductRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/cat/product/new", name="cat_product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $catProduct = new CatProduct();
        $form = $this->createForm(CatProductType::class, $catProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($catProduct);
            $entityManager->flush();

            return $this->redirectToRoute('cat_product_index');
        }

        return $this->render('admin/pages/catProduct/newCat.html.twig', [
            'cat_product' => $catProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/cat/product/{id}", name="cat_product_show", methods={"GET"})
     */
    public function show(CatProduct $catProduct): Response
    {
        return $this->render('admin/pages/catProduct/showCat.html.twig', [
            'cat_product' => $catProduct,
        ]);
    }

    /**
     * @Route("/admin/cat/product/{id}/edit", name="cat_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CatProduct $catProduct): Response
    {
        $form = $this->createForm(CatProductType::class, $catProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cat_product_index');
        }

        return $this->render('admin/pages/catProduct/editCat.html.twig', [
            'cat_product' => $catProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/cat/product/{id}", name="cat_product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CatProduct $catProduct): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catProduct->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($catProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cat_product_index');
    }
}
