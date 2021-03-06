<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $urlGenerator;

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('homepage');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
//        return new RedirectResponse($this->urlGenerator->generate('app_login'));
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    /**
     * @Route ("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,GuardAuthenticatorHandler $guardAuthenticatorHandler,LoginFormAuthenticator $loginFormAuthenticator)
    {
        $form = $this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /** @var User $user */
            $user = $form->getData();
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $form['plainPassword']->getData()
            ));
            if (true === $form['agreedTerms']->getData()){
                $user->agreeTerms();
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
              $user,
              $request,
              $loginFormAuthenticator,
              'main'
            );
        }
       return $this->render('security/register.html.twig', [
           'registrationForm'=>$form->createView()
       ]);
    }
}
