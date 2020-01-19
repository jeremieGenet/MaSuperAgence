<?php
namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em; // Correspond à notre entityManager

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.property.index")
     *
     * @return Response
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        //dd($properties);
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }


    /**
     * @Route("/admin/property/create", name="admin.property.new")
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $property = new Property();
        // Ajout de notre formulaire ("PropertyType"), et le type de données ($property, notre entité)
        $form = $this->createForm(PropertyType::class, $property);

        // Gestion de la requête de notre formulaire (via la méthode handleRequest() avec en param la requête "$request")
        $form->handleRequest($request);
        
        // Vérif si le formulaire est soummis et valid
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($property); // On fait persister notre nouvelle entité (nouveau bien, $property)
            $this->em->flush(); // On envoie les données dans la bdd
            $this->addFlash('success', 'Le bien a bien été créé !!!'); // Message flash de réussite
            return $this->redirectToRoute('admin.property.index'); // Redirection vers le listing des biens
        }

        return $this->render('admin/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView() // Dans les options du rendu on ajoute avec cette méthode la vue du formulaire créé
        ]);
    }



    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     *
     * @return Response
     */
    public function edit(Property $property, Request $request): Response // Injection de "Request" que permet faire une requête (pour notre formulaire)
    {
        // Ajout de notre formulaire ("PropertyType"), et le type de données ($property, notre entité)
        $form = $this->createForm(PropertyType::class, $property);
        // Gestion de la requête de notre formulaire (via la méthode handleRequest() avec en param la requête "$request")
        $form->handleRequest($request);
        
        // Vérif si le formulaire est soummis et valid
        if($form->isSubmitted() && $form->isValid()){
            // PAS BESOIN DU "$this->em->persist($property)" ICI (car l'em sait déjà s'il y a des modif à faire ou non)
            $this->em->flush(); // On envoie les données dans la bdd
            $this->addFlash('success', 'Le bien a bien été modifié !!!'); // Message flash de réussite

            return $this->redirectToRoute('admin.property.index'); // Redirection vers le listing des biens
        }


        return $this->render('admin/property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView() // Dans les options du rendu on ajoute avec cette méthode la vue du formulaire créé
        ]);
    }


    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     *
     * @return Response
     */
    public function delete(Property $property, Request $request): Response
    {
        // Vérife si le token de soumission du formulaire est valide (si c'est le cas on supprime le bien, sinon redirection)
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Le bien a bien été supprimé !!!'); // Message flash de réussite
        }
        
        return $this->redirectToRoute('admin.property.index'); // Redirection vers le listing des biens
    }


}