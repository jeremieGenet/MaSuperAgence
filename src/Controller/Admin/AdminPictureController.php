<?php

namespace App\Controller\Admin;


use App\Entity\Picture;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin/picture")
 */
class AdminPictureController extends AbstractController{
    
    /**
     * @Route("/{id}", name="admin.picture.delete", methods="DELETE")
     */
    public function delete(Picture $picture, Request $request)
    {
        // Récup des données de la requête AJAX, et on les décode sous forme de tableau associatif (option "true")
        $data = json_decode($request->getContent(), true);

        // "isCsrfTokenValid()" méthode symfony (de Request) permet de donnée un token à une requête (pour en garantir l'intégrité, utile lors de la suppression via un lien et non un formulaire)
        if ($this->isCsrfTokenValid('delete' . $picture->getId(), $data['_token'])) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($picture);
            $entityManager->flush();
            return new JsonResponse(['success' => 1]); // Retourn une reponse en JSON qui vaut "'success' => 1"
        }

        return new JsonResponse(['error' => 'Token invalid'], 400); // Retourn une reponse en JSON qui vaut "Token invalid"
    }

}