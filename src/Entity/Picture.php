<?php

namespace App\Entity;

use App\Entity\Property;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich; // librairie d'upload de fichier (utilisé directement sur le nom de la class Property)

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 * @Vich\Uploadable()
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Propriété qui représente une image (de type File, soit une ressource) et qui est utilisé pour le fonctionnement de l'upload du fichier
     * 
     * UPLOAD DE FICHIER (librairie vich/uploader-bundle)
     * PARAMS Vich\UploadableField = (mapping="voir config/package/vich_uploader.yaml" et fileNameProperty="nom de la propriété de l'entité qui représente l'image")
     *
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="filename")
     * @Assert\Image(mimeTypes="image/jpeg")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Property", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        return $this;
    }

}
