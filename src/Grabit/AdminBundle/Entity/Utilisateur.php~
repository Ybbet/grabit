<?php

namespace Grabit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Utilisateur
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Grabit\AdminBundle\Entity\UtilisateurRepository")
 */
class Utilisateur
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer", unique=true, nullable=false)
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Votre nom est obligatoire.")
     * @Assert\MinLength(limit=2,message="Votre nom doit contenir au moins 2 caractères.")
     * @Assert\MaxLength(limit=50,message="Votre nom doit contenir au maximum 50 caractères.")
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(name="prenom", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Votre prénom est obligatoire.")
     * @Assert\MinLength(limit=2,message="Votre prénom doit contenir au moins 2 caractères.")
     * @Assert\MaxLength(limit=50,message="Votre prénom doit contenir au maximum 50 caractères.")
     */
    private $prenom;

    /**
     * @var string
     * @ORM\Column(name="adresse", type="text", nullable=false)
     * @Assert\NotBlank(message="Votre adresse est obligatoire dans le cadre de la facuration.")
     */
    private $adresse;

    /**
     * @var integer
     * @ORM\Column(name="code_postal", type="integer")
     * @Assert\NotBlank(message="Veuillez rentrer le code postal s'il vous plaît.")
     */
    private $code_postal;

    /**
     * @var string
     * @ORM\Column(name="ville", type="string", length=50 , nullable=false)
     * @Assert\NotBlank(message="Veuillez rentrer le nom de la ville s'il vous plaît.")
     */
    private $ville;

    /**
     * @var string
     * @ORM\Column(name="pays", type="string", length=50 , nullable=false)
     * @Assert\NotBlank(message="Veuillez rentrer le pays s'il vous plaît.")
     */
    private $pays;


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
     * Set nom
     *
     * @param string $nom
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    
        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Utilisateur
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    
        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set code_postal
     *
     * @param integer $codePostal
     * @return Utilisateur
     */
    public function setCodePostal($codePostal)
    {
        $this->code_postal = $codePostal;
    
        return $this;
    }

    /**
     * Get code_postal
     *
     * @return integer 
     */
    public function getCodePostal()
    {
        return $this->code_postal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Utilisateur
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    
        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return Utilisateur
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    
        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }
}