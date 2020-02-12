<?php
namespace App\Controller;

use Twig\Environment;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


// Gère l'affichage de la page d'accueil ("/")
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home") 
     * @param PropertyRepository $repository 
     * @return Response
     */
    public function index(PropertyRepository $repository): Response
    {
        // Récup des 4 derniers biens non-vendus (sold = false)
        $properties = $repository->findLatest();
        //dd($properties);
        return $this->render('pages/home.html.twig',['properties' => $properties]);

    }

}