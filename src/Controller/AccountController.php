<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *@IsGranted("ROLE_USER")
 */
class AccountController extends BaseController
{
    /**
     * @Route("/change_language/{lang}", name="change_language")
     */
    public function changeLanguage(Request $request, $lang): Response
    {
        $availableLanguages = ['/en/','/al/'];
        $referer = $request->headers->get('referer');
        $referer = str_replace($availableLanguages, "/".$lang."/", $referer);
        $this->addFlash("success", "Lamguage was changed to: ".$lang);
        return $this->redirect($referer);
    }
    /**
     * @Route("/account", name="app_account")
     */
    public function index(LoggerInterface $logger): Response
    {
        $logger->debug('Checking account page for ' .$this->getUser()->getEmail());
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    //ApiFunction to return the JSON representation of whoever is logged in

    /**
     * @Route ("/api/account", name="api_account")
     */
    public function accountApi()
    {
        //marrim user object
      $user = $this->getUser();
      //kthejme objektin ne json;
        return $this->json($user, 200,[],[
            'groups'=>['main']
        ]);

    }
}
