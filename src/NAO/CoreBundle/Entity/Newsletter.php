<?php

namespace NAO\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Newsletter
 *
 * @ORM\Table(name="newsletter")
 * @ORM\Entity(repositoryClass="NAO\CoreBundle\Repository\NewsletterRepository")
 * @UniqueEntity("mail", message="Cette adresse e-mail est déjà utilisé.")
 */
class Newsletter
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
     * @ORM\Column(name="mail", type="string", length=255, unique=true)
     * @Assert\Regex(
     *      pattern="/^[a-z0-9._-]{1,}@[a-z0-9._-]{2,}\.[a-z]{2,4}$/",
     *       message="Votre mail n'est pas au bon format. Exemple: adresse@mail.com.")
     * @Assert\NotBlank(message="Vous devez entrer une adresse mail.")
     */
    private $mail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $createAt;

    public function __construct()
    {
        $this->setCreateAt(new \DateTime);
    }

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
     * Set mail
     *
     * @param string $mail
     *
     * @return Newsletter
     */
    public function setMail($mail)
    {
        $this->mail = htmlspecialchars($mail);

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Newsletter
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }
}

