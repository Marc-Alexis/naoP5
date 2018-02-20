<?php

namespace NAO\BirdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity(repositoryClass="NAO\BirdBundle\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255)
     * @Assert\NotBlank(message="Vous devez choisir une image.")
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="Vous devez entrer du texte.")
     */
    private $alt;

    private $file;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Photo
     */
    public function setAlt($alt)
    {
        $this->alt = htmlspecialchars($alt);

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Photo
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function upload()
    {
        // 1. S'il y a un fichier
        if ($this->getFile() !== null && (int) $this->getFile()->getError() === 0)
        {
            // 1. Récupération de l'extension
            $extension = pathinfo($this->file->getClientOriginalName())['extension'];

            $goodExtension = array('jpg', 'jpeg');

            if (in_array($extension, $goodExtension))
            {
                // 2. Vérification de la taille du fichier
                if ($this->getFile()->getSize() <= 1000000)
                {
                    $filename = $this->file->getClientOriginalName();

                    $this->filename = $filename;

                    $this->file->move($this->getUploadRootDir(), $filename);
            
                }
                else
                {
                    return 'error_size';
                }
            }
            else
            {
                return 'error_extension';
            }
        }
        else
        {
            return 'error_file';
        }

     }

    public function getUploadDir()
    {
        return 'uploads/img';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }
}
