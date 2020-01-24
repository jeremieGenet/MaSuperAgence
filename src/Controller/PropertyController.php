<?php
namespace App\Controller;

use App\Entity\PropertySearch;
use App\Entity\Property;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    // Récup du $repository (permet de faire des requêtes) et de $entityManager (permet de récup le résultat des requêtes)
    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        // Recherche de bien
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        // Biens paginés
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1), 12 // 1 = numéro de la page, et 12 = limite par page
        );

        // Affichage (rendu) dans index.html.twig avec un param (current_menu, pour donner la classe active au menu)
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties', // 'properties' permet donner la classe active au menu dans index.html.twig
            'properties' => $properties,    // $properties permet de transmettre les biens paginés
            'form' => $form->createView()   // $form permet de créer la vue du formulaire (de recherche) 
        ]);
    }


    /**
     * @Route("/bien/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug): Response 
    {
        // Condition si le slug de l'url est différent du slug du bien (alors redirection vers le bien avec son slug) IMPORTANT POUR LE REFERENCEMENT
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301); // 301 pour le statut de la redirection (301 = redirection permanente), param optionel
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }

}