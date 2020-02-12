<?php
namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Notification\ContactNotification;
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
        // Recherche de bien (formulaire de recherche)
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        // Biens paginés
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1), 8 // 1 = numéro de la page, et 8 = limite de biens par page
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
    public function show(Property $property, string $slug, Request $request, ContactNotification $notification): Response 
    {
        // Condition si le slug de l'url est différent du slug du bien (alors redirection vers le bien avec son slug) IMPORTANT POUR LE REFERENCEMENT
        if($property->getSlug() !== $slug){
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301); // 301 pour le statut de la redirection (301 = redirection permanente utile pour le navigateur et le référencement), param optionel
        }

        // Formulaire de contact (dans le but de l'envoyer dans le render())
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        // Condition si le formulaire de contact est soumis (feedback et redirection, le traitement de l'envoie d'email est gérer par notre classe Notification)
        if($form->isSubmitted() && $form->isValid()){
            $notification->notify($contact); // Envoie d'un mail à l'utilisateur qui à soummis le formulaire
            $this->addFlash('success', 'Votre email a bien été envoyé !');
            
            // Redirection vers le bien en relation avec l'envoie de formulaire
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ]);
            
        }

        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties',
            'form' => $form->createView()
        ]);
    }

}