<?php

namespace Grabit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Souscription
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Grabit\AdminBundle\Entity\SouscriptionRepository")
 */
class Souscription
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(name="id_utilisateur", type="integer", nullable=false, unique=true)
     * @ORM\OneToOne(targetEntity="Utilisateur", inversedBy="id", cascade={"persist","remove"})
     * @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     */
    private $id_utilisateur;

    /**
     * @var integer
     * @ORM\Column(name="id_abonnement", type="integer", nullable=false)
     * @ORM\OneToOne(targetEntity="Abonnement", inversedBy="id", cascade={"remove"})
     * @ORM\JoinColumn(name="id_abonnement", referencedColumnName="id")
     */
    private $id_abonnement;
    
    /**
     * @var \DateTime
     * @ORM\Column(name="fin_validite", type="datetime", nullable=false)
     */
    private $fin_validite;

//    public function __construct() {
//	$this->id_abonnement = new ArrayCollection();
//	$this->id_utilisateur = new ArrayCollection() ;
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
     * Set id_utilisateur
     *
     * @param integer $idUtilisateur
     * @return Souscription
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
     * Set id_abonnement
     *
     * @param integer $idAbonnement
     * @return Souscription
     */
    public function setIdAbonnement($idAbonnement)
    {
        $this->id_abonnement = $idAbonnement;
    
        return $this;
    }

    /**
     * Get id_abonnement
     *
     * @return integer 
     */
    public function getIdAbonnement()
    {
        return $this->id_abonnement;
    }

    /**
     * Set fin_validite
     *
     * @param \DateTime $finValidite
     * @return Souscription
     */
    public function setFinValidite($finValidite)
    {
        $this->fin_validite = $finValidite;
    
        return $this;
    }

    /**
     * Get fin_validite
     *
     * @return \DateTime 
     */
    public function getFinValidite()
    {
        return $this->fin_validite;
    }
    
    
    public function getIdUtilisateurPublic()
    {
	$this->id_utilisateur_public = $this->id_utilisateur ;
    }
    public function getIdAbonnementPublic()
    {
	$this->id_abonnement_public = $this->id_abonnement ;
    }
}