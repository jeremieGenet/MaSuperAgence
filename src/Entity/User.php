<?php

namespace App\Entity;

use Serializable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Retourne le ou les roles d'un utilisateur
     * Méthode issue de l'interface 'UserInterface'
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }

    /**
     * Permet de récup le 'salt' de l'encodage de password (non utilisé ici, donc return null)
     * Méthode issue de l'interface 'UserInterface'
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Supprime les infos 'sensibles' d'un utilisateur (non utilisé ici)
     * Méthode issue de l'interface 'UserInterface'
    */
    public function eraseCredentials()
    {
        
    }

    /**
     * Permet de convertir un objet en chaîne de caractères
     * Méthode issue de l'interface 'Serializable'
    */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    /**
     * Permet de convertir une chaîne en objet
     * Méthode issue de l'interface 'UserInterface'
    */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }

}
