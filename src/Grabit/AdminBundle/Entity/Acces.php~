<?php

namespace Grabit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection ;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * Acces
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Grabit\AdminBundle\Entity\AccesRepository")
 */
class Acces implements UserInterface
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=50, nullable=false, unique=true)
     * @Assert\Email(message="Vous devez rentrer un email sous la forme nom@domaine.com")
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=64, nullable=false)
     * @Assert\NotBlank(message="Veuillez saisir un mot de passe")
     */
    private $password;

    /**
     * @var integer
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=false, unique=true)
     * @ORM\OneToOne(targetEntity="Utilisateur", inversedBy="id", cascade={"persist","remove"})
     */
    private $id_utilisateur;

    /**
     * @var boolean
     * @ORM\Column(name="bloque", type="boolean")
     */
    private $bloque;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $salt;

    /**
     * @var \DateTime
     * @ORM\Column(name="connexion", type="datetime")
     */
    private $connexion;

    /**
     *
     * @Assert\Type(type="Grabit\AdminBundle\Entity\Utilisateur")
     */
    protected $utilisateur;


//    public function __construct() {
//	$this->id_utilisateur = new ArrayCollection();
//    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Acces
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Acces
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     * @inheritDoc
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set id_utilisateur
     *
     * @param integer $idUtilisateur
     * @return Acces
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->id_utilisateur = $idUtilisateur;
    
        return $this;
    }

    /**
     * Get id_utilisateur
     *
     * @return integer 
     */
    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }

    /**
     * Set bloque
     *
     * @param boolean $bloque
     * @return Acces
     */
    public function setBloque($bloque)
    {
        $this->bloque = $bloque;
    
        return $this;
    }

    /**
     * Get bloque
     *
     * @return boolean 
     */
    public function getBloque()
    {
        return $this->bloque;
    }

    /**
     * Set connexion
     *
     * @param \DateTime $connexion
     * @return Acces
     */
    public function setConnexion($connexion)
    {
        $this->connexion = $connexion;
    
        return $this;
    }

    /**
     * Get connexion
     *
     * @return \DateTime 
     */
    public function getConnexion()
    {
        return $this->connexion;
    }
    
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;
    }
    
    public function __construct()
    {
        $this->bloque = true;
        $this->salt = md5(uniqid(null, true));
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    public function isEqualTo(UserInterface $user)
    {
	return $this->email === $user->getUsername();
    }
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->bloque;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

}