<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="login")
     *
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        
        $error = $authenticationUtils->getLastAuthenticationError(); // "getLastAuthenticationError()" est une méthode de "AuthenticationUtils"
        $lastUsername = $authenticationUtils->getLastUsername();     // "getLastUsername()" est une méthode de "AuthenticationUtils"

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

}