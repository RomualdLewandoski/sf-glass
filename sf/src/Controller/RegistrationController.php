<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\CatProductRepository;
use App\Repository\GenderCatRepository;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\AuthAuthenticator;
use Swift_Mailer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             GuardAuthenticatorHandler $guardHandler,
                             AuthAuthenticator $authenticator,
                             UserRepository $userrepo,
                             GenderCatRepository $genderCatRepository,
                             CatProductRepository $catProductRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $error = null;
        if ($form->isSubmitted() && $form->isValid()) {
            $getByEmail = $userrepo->findBy(['email' => $form->get('email')->getData()]);
            $getByuserName = $userrepo->findBy(['username' => $form->get('username')->getData()]);
            if ($getByEmail == null && $getByuserName == null) {
                // encode the plain password
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                //$user->setRoles(["ROLE_ADMIN"]);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $transport = (new \Swift_SmtpTransport('moonly.fr', 25))
                    ->setUsername("admin@moonly.fr")
                    ->setPassword("Afpagroupe6");
                $message = (new \Swift_Message('Hello Email'))
                    ->setFrom('admin@moonly.fr')
                    ->setTo($user->getEmail())
                    ->setBody("Salut bienvenue sur mon super site avec symfo");
                $mailer = new Swift_Mailer($transport);

                $mailer->send($message);

                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // firewall name in security.yaml
                );
            } else {
                $error = "Email or username already defined";
            }

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'genderCat' => $genderCatRepository->findAll(),
            'productCats' => $catProductRepository->findAll(),
            'error' => $error

        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }


        //$this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('home');
    }
}
