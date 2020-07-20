<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Cart;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\UserType;
use App\Repository\AddressRepository;
use App\Repository\CartRepository;
use App\Repository\CatProductRepository;
use App\Repository\GenderCatRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Security\AuthAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\Json;
use function Sodium\add;

class ProfileController extends AbstractController
{

    /**
     * @Route("/profile", name="profile")
     */
    public function index(UserRepository $userRepository, GenderCatRepository $genderCatRepository, CatProductRepository $catProductRepository)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $userCredential = $this->getUser();
        $user = $userRepository->findOneBy(['username' => $userCredential->getUsername()]);
        return $this->render('profile/index.html.twig', [
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'controller_name' => $user->getUsername(),
            'orders' => $user->getOrders()
        ]);
    }

    /**
     * @Route("/profile/informations", name="profile_informations")
     */
    public function myInfos(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepo, GenderCatRepository $genderCatRepository, CatProductRepository $catProductRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $userCredentials = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $user = $userRepo->findOneBy(['username' => $userCredentials->getUsername()]);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $error = null;
        if ($form->isSubmitted() && $form->isValid()) {

            $uow = $em->getUnitOfWork();
            $oldUser = $uow->getOriginalEntityData($user);
            $checkPass = $passwordEncoder->isPasswordValid($userCredentials, $form->get('password')->getData());
            if ($checkPass) {
                $error = "Profil sauvegardé";
                $newPass = $form->get('newPass')->getData();
                $newPassConf = $form->get('newPassConf')->getData();
                if ($newPass != null && trim($newPass) != "") {
                    if ($newPass === $newPassConf) {
                        $passCrypt = $passwordEncoder->encodePassword($userCredentials, $newPass);
                        $user->setPassword($passCrypt);
                    } else {
                        $error = "Le nouveau mot de passe et sa confirmation ne correspondent pas";
                    }

                }

                if ($oldUser['username'] != $form->get('username')->getData()) {
                    $getByuserName = $userRepo->findBy(['username' => $form->get('username')->getData()]);
                    if ($getByuserName == null) {
                        $user->setUsername($form->get('username')->getData());
                    } else {
                        $user->setUsername($oldUser['username']);
                        $error = "Username already defined";
                    }
                }
                if ($oldUser['email'] != $form->get('email')->getData()) {
                    $getByEmail = $userRepo->findBy(['email' => $form->get('email')->getData()]);
                    if ($getByEmail == null) {
                        $user->setEmail($form->get('email')->getData());
                    } else {
                        $user->setEmail($oldUser['email']);
                        $error = "email already defined";
                    }
                }


                $em->flush();

            } else {
                $error = "Invalid password";
            }
            $this->addFlash('error', $error);
            return $this->redirectToRoute('profile_informations');
        }


        return $this->render('profile/informations.html.twig', [
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'userForm' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("/profile/address", name="profile_address_list")
     */
    public function address(GenderCatRepository $genderCatRepository, CatProductRepository $catProductRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $userCredentials = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('App:User');
        $user = $userRepo->findOneBy(['username' => $userCredentials->getUsername()]);

        $address = $em->getRepository('App:Address')->findBy(['user' => $user]);

        return $this->render('profile/address.html.twig', [
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'addresses' => $address,
        ]);
    }

    /**
     * @Route("/profile/address/new", name="profile_address_add")
     */
    public function addAddress(Request $request, GenderCatRepository $genderCatRepository, CatProductRepository $catProductRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('App:User');
        if ($form->isSubmitted() && $form->isValid()) {
            $userEntity = $userRepo->findOneBy(['username' => $user->getUsername()]);
            $address->setUser($userEntity);
            $em->persist($address);
            $em->flush();
            return $this->redirectToRoute("profile_address_list");
        }
        return $this->render('profile/addressNew.html.twig', [
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'addressForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/address/edit/{id}", name="profile_address_edit")
     */
    public function editAddress(Request $request, int $id, GenderCatRepository $genderCatRepository, CatProductRepository $catProductRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $addressRepo = $em->getRepository('App:Address');
        $address = $addressRepo->find($id);
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('profile_address_list');

        }
        return $this->render('profile/addressEdit.html.twig', [
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'addressForm' => $form->createView(),
        ]);

    }

    /**
     * @Route("/profile/address/{id}", name="profile_address_delete", methods={"DELETE"})
     */
    public function deleteAddress(Request $request, int $id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $em = $this->getDoctrine()->getManager();
        $addressRepo = $em->getRepository('App:Address');
        $address = $addressRepo->find($id);
        if ($this->isCsrfTokenValid('delete' . $address->getId(), $request->request->get('_token'))) {
            $em->remove($address);
            $em->flush();
        }
        return $this->redirectToRoute('profile_address_list');

    }

    /**
     * @Route("/profile/cart", name="cart")
     */
    public function cart(UserRepository $userRepository, GenderCatRepository $genderCatRepository, CatProductRepository $catProductRepository)
    {
        $userCredential = $this->getUser();
        $user = $userRepository->findOneBy(['username' => $userCredential->getUsername()]);
        $carts = $user->getCarts();
        return $this->render('profile/cart.html.twig', [
            'livraison' => 3.99,
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'carts' => $carts,
        ]);
    }

    /**
     * @Route("/profile/checkout", name="checkout")
     */
    public function checkout(UserRepository $userRepository, GenderCatRepository $genderCatRepository, CatProductRepository $catProductRepository)
    {
        $userCredential = $this->getUser();
        $user = $userRepository->findOneBy(['username' => $userCredential->getUsername()]);
        $carts = $user->getCarts();
        $addresses = $user->getAddresses();

        return $this->render('prodile/checkout.html.twig', [
            'livraison' => 3.99,
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'carts' => $carts,
            'addresses' => $addresses
        ]);
    }

    /**
     * @Route("/profile/checkout/complete", name="complete_checkout")
     */
    public function completeCheckout(Request $request, UserRepository $userRepository, AddressRepository $addressRepository, GenderCatRepository $genderCatRepository, CatProductRepository $catProductRepository)
    {
        $userCredential = $this->getUser();
        $user = $userRepository->findOneBy(['username' => $userCredential->getUsername()]);
        $addressId = $request->get('address');
        $em = $this->getDoctrine()->getManager();
        $carts = $user->getCarts();
        $livraison = 3.99;

        $msg = "";
        if ($addressId != null) {
            $address = $addressRepository->find($addressId);
            if ($address != null && $address->getUser() == $user) {
                $paymentType = $request->get('paymentType');
                if ($paymentType != null) {
                    $flag = true;
                    if ($paymentType == 1) {
                        $cbNumber = $request->get('cbNumber');
                        $cvc = $request->get('cvc');
                        $month = $request->get('month');
                        $year = $request->get('year');
                        if ($cbNumber == null || $cvc == null || $month == null || $year == null) {
                            $flag = false;
                        }
                    }
                    if ($flag) {
                        $order = (new Order())
                            ->setUser($user)
                            ->setAddress($address)
                            ->setPrice(0)
                            ->setDate(new \DateTime('now'))
                            ->setStatus(0)
                            ->setPaymentType($paymentType);
                        $em->persist($order);
                        $em->flush();
                        $subtotal = 0;
                        foreach ($carts as $cart) {
                            $subtotal += $cart->getProduct()->getPrice() * $cart->getQuantity();
                            $orderProduct = (new OrderProduct())
                                ->setOrderLink($order)
                                ->setProduct($cart->getProduct())
                                ->setPrice($cart->getProduct()->getPrice())
                                ->setQuantity($cart->getQuantity());
                            $cart->getProduct()->setStock($cart->getProduct()->getStock() - $cart->getQuantity());
                            $em->remove($cart);
                            $em->persist($orderProduct);
                            $em->flush();
                        }
                        $order->setPrice($subtotal + $livraison);
                        $em->flush();
                        $msg = "Votre commande a été validée";
                    } else {
                        $msg = "Champs manquant sur le payement par CB";
                    }

                } else {
                    $msg = "Moyen de payement invalide";
                }
            } else {
                $msg = "Addresse introuvable ou n'apaprtenant pas a l'utilisateur";
            }
        } else {
            $msg = "Adresse introuvable";
        }
        return $this->render('prodile/checkoutComplete.html.twig', [
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'msg' => $msg
        ]);
    }

    /**
     * @Route("/profile/cart/update", name="cart_update")
     */
    public function updateCart(Request $request, UserRepository $userRepository, CartRepository $cartRepository)
    {
        $userCredential = $this->getUser();
        $user = $userRepository->findOneBy(['username' => $userCredential->getUsername()]);
        $productQt = $request->get('productQt');
        $cartId = $request->get('productId');
        if ($productQt != null && $cartId != null) {
            $cart = $cartRepository->findOneBy(["user" => $user, "id" => $cartId]);
            if ($cart != null) {
                $product = $cart->getProduct();
                if ($product->getStock() >= $productQt) {
                    $cart->setQuantity($productQt);
                    $this->getDoctrine()->getManager()->flush();
                }
            }
        }
        return $this->redirectToRoute("cart");

    }

    /**
     * @Route("/profile/cart/remove/{id}", name="cart_remove")
     */
    public function removeCart(UserRepository $userRepository, CartRepository $cartRepository, int $id)
    {
        if ($id != null) {
            $userCredential = $this->getUser();
            $user = $userRepository->findOneBy(['username' => $userCredential->getUsername()]);
            $cart = $cartRepository->findOneBy(["user" => $user, "id" => $id]);
            if ($cart != null) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($cart);
                $em->flush();
            }
        }
        return $this->redirectToRoute("cart");
    }

    /**
     * @Route("/profile/cart/api/count", name="api_get_cart", methods={"GET"})
     */
    public function countCart(UserRepository $userRepository): JsonResponse
    {
        $obj = new \stdClass();
        $userCredential = $this->getUser();
        $user = $userRepository->findOneBy(['username' => $userCredential->getUsername()]);
        $obj->cart = count($user->getCarts());
        return new JsonResponse($obj);
    }

    /**
     * @Route("/profile/cart/api/add", name="api_add_cart", methods={"POST"})
     */
    public function addToCart(Request $request, UserRepository $userRepository, ProductRepository $productRepository): JsonResponse
    {
        $obj = new \stdClass();
        $userCredential = $this->getUser();
        $user = $userRepository->findOneBy(['username' => $userCredential->getUsername()]);
        $productId = $request->get('productId');
        $quantity = $request->get('productQt');
        $product = $productRepository->find($productId);
        $em = $this->getDoctrine()->getManager();
        if ($product == null) {
            $obj->state = 0;
            $obj->error = "Le produit n'existe pas";
        } else {
            if ($product->getStock() < $quantity) {
                $obj->state = 0;
                $obj->error = "Le stock ne permet pas cette quantitée, merci de recharger la page afin d'obtenir les derniers stocks";
            } else {
                $carts = $user->getCarts();
                $flag = false;
                $err = false;
                foreach ($carts as $cart) {
                    if ($cart->getProduct() == $product) {
                        if ($cart->getQuantity() + $quantity <= $product->getStock()) {
                            $cart->setQuantity($cart->getQuantity() + $quantity);
                            $em->flush();
                            $flag = true;
                        } else {
                            $flag = true;
                            $err = true;
                        }
                    }
                }
                if (!$flag) {
                    $cart = new Cart();
                    $cart->setUser($user);
                    $cart->setProduct($product);
                    $cart->setQuantity($quantity);
                    $em->persist($cart);
                    $em->flush();
                }
                if ($err) {
                    $obj->state = 0;
                    $obj->error = "Le stock ne permet pas cette quantitée, merci de recharger la page afin d'obtenir les derniers stocks, votre panier n'as pas été mis a jour";
                } else {
                    $obj->state = 1;
                }
            }
        }
        return new JsonResponse($obj);
    }
}
