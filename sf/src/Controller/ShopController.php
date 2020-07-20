<?php

namespace App\Controller;

use App\Entity\Ratings;
use App\Form\RatingsType;
use App\Repository\CatProductRepository;
use App\Repository\GenderCatRepository;
use App\Repository\ProductRepository;
use App\Repository\RatingsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop/{id}", name="shop")
     */
    public function index(Request $request, GenderCatRepository $genderCatRepository, CatProductRepository $catProductRepository, ProductRepository $productRepository, int $id)
    {
        $cat = $catProductRepository->find($id);
        $gender = $request->get('gender');
        $orderBy = $request->get('orderby');
        $arr = ["cat" => $id];
        $order = null;
        if ($gender == null) {
            $gender = "all";
        } else {
            if ($gender != "all") {

                $arr['gender'] = $gender;
            }
        }
        if ($orderBy == null) {
            $orderBy = "menu_order";
        } else {
            if ($orderBy != "menu_order") {
                switch ($orderBy) {
                    case "date":
                        $order = ['dateAjout' => 'DESC'];
                        break;
                    case "price":
                        $order = ['price' => 'ASC'];
                        break;
                    case "price-desc":
                        $order = ['price' => 'DESC'];
                        break;
                    case "rating":
                        $order = ['notes' => "DESC"];
                        break;
                    default:
                        $order = null;
                        break;
                }
            }
        }
        $products = $productRepository->findBy($arr, $order);
        if ($cat == null) {
            return $this->redirectToRoute("main");
        }
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'cat' => $cat,
            'products' => $products,
            'catId' => $id,
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'filterGender' => $gender,
            'filterOrder' => $orderBy

        ]);
    }

    /**
     * @Route("/shop/produit/{id}", name="shop_view")
     */
    public function shopView(Request $request, GenderCatRepository $genderCatRepository, CatProductRepository $catProductRepository, ProductRepository $productRepository, UserRepository $userRepo, RatingsRepository $ratingsRepository, int $id)
    {
        $product = $productRepository->find($id);
        if ($product == null) {
            return $this->redirectToRoute("main");
        }
        $rating = new Ratings();
        $form = $this->createForm(RatingsType::class, $rating);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $userCred = $this->getUser();
            $user = $userRepo->findOneBy(['username' => $userCred->getUsername()]);
            $rating->setNote($request->get('rating'));
            $rating->setUser($user);
            $rating->setProduct($product);
            $em->persist($rating);
            $em->flush();

            $rates = $ratingsRepository->findBy(['product' => $product]);
            $totalNotes = 0;
            $totalRate = count($rates);
            foreach ($rates as $avis) {
                $totalNotes += $avis->getNote();
            }
            $product->setNotes($totalNotes / $totalRate);
            $em->flush();
        }
        return $this->render('shop/produit.html.twig', [
            'product' => $product,
            'controller_name' => 'ShopController',
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'form' => $form->createView(),
            'ratings' => $ratingsRepository->findBy(['product' => $product])
        ]);
    }
}
