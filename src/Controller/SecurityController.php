<?php
namespace App\Controller;

//use App\Entity\Property;
//use App\Form\PropertyType;
//use App\Repository\PropertyRepository;
//use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
//namespace Symfony\Component\Security\Http\Authentication;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="login")
     *
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        //dd($authenticationUtils);
        //dd($lastUsername);

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

}