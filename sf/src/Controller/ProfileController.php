<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\AuthAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Sodium\add;

class ProfileController extends AbstractController
{

    /**
     * @Route("/profile", name="profile")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('profile/index.html.twig', [
            'controller_name' => $user->getUsername(),
        ]);
    }

    /**
     * @Route("/profile/informations", name="profile_informations")
     */
    public function myInfos(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepo)
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
                    if ($newPass === $newPassConf){
                        $passCrypt = $passwordEncoder->encodePassword($userCredentials, $newPass);
                        $user->setPassword($passCrypt);
                    }else{
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
            'userForm' => $form->createView(),
            'error' => $error
        ]);
    }

    /**
     * @Route("/profile/address", name="profile_address_list")
     */
    public function address()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $userCredentials = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('App:User');
        $user = $userRepo->findOneBy(['username' => $userCredentials->getUsername()]);

        $address = $em->getRepository('App:Address')->findBy(['user' => $user]);

        return $this->render('profile/address.html.twig', [
            'addresses' => $address,
        ]);
    }

    /**
     * @Route("/profile/address/new", name="profile_address_add")
     */
    public function addAddress(Request $request)
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
            'addressForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile/address/edit/{id}", name="profile_address_edit")
     */
    public function editAddress(Request $request, int $id)
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


}
