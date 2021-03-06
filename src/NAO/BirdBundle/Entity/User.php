<?php

namespace NAO\BirdBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 * 
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="NAO\BirdBundle\Repository\UserRepository")
 * @UniqueEntity("username", message="Cette adresse de courriel est déjà utilisé.")
 */
class User implements UserInterface
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
     * @ORM\Column(name="firstname", type="string", length=255)
     * @Assert\Regex(pattern="/[A-Z]{1,}[a-zéïî]{1,}/", message="Votre prénom n'est pas au bon format. Exemple : Jean")
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     * @Assert\Regex(pattern="/[A-Z]{1,}[a-zéïî]{1,}/", message="Votre nom de famille n'est pas au bon format. Exemple : Dupond")
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @Assert\Regex(pattern="/^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/", message="Votre mail n'est pas au bon format. Exemple : adresse@mail.com")
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit faire au minimum 8 caractères.")
     * @Assert\NotBlank()
     */
    private $password;

    /**
    * @var string
    *
    * @ORM\Column(name="salt", type="string", length=255)
    */
    private $salt;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     * @Assert\NotBlank()
     */
    private $roles;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     * @Assert\NotBlank()
     */
    private $createAt;

    public function __construct() 
    {
        $this->setSalt('sup3r_s@17');
        $this->setRoles('ROLE_USER');
        $this->setCreateAt(new \DateTime());
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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = htmlspecialchars($firstname);

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = htmlspecialchars($lastname);

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = htmlspecialchars($username);

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = htmlspecialchars($password);

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = array($roles);

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return User
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

    public function eraseCredentials()
     {
     }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }
}
