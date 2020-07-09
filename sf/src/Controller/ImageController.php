<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/gallery")
 */
class ImageController extends AbstractController
{
    /**
     * @Route("/", name="image_index",  methods={"GET","POST"})
     */
    public function index(Request $request, ImageRepository $imageRepository): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $image->setUpdatedAt( new \DateTime('now'));
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('image_index');
        }

        return $this->render('admin/pages/gallery/imageList.html.twig', [
            'images' => $imageRepository->findAll(),
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="image_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Image $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('image_index');
    }
}
