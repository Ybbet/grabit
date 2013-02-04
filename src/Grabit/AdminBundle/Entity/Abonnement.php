<?php

namespace Grabit\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * Abonnement
 */
class Abonnement
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
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Le nom de l'abonnement est obligatoire.")
     * @Assert\MinLength(limit=2,message="Le nom de l'abonnement doit contenir au moins 2 caractères.")
     * @Assert\MaxLength(limit=50,message="Le nom de l'abonnement doit contenir au maximum 50 caractères.")
     */
    private $nom;

    /**
     * @var integer
     * @ORM\Column(name="espace", type="integer")
     * @Assert\NotBlank(message="Veuillez renseigner l'espace alloué à l'abonnement.")
     */
    private $espace;

    /**
     * @var integer
     * @ORM\Column(name="prix", type="integer")
     * @Assert\NotBlank(message="N'oubliez pas le tarif de l'abonnement.")
     */
    private $prix;
    
    
    /**
     * Pour la construction du __toString()
     * @var type 
     */
    protected $headers;


    public function __toString() {
        if (!$this->headers) {
            return '';
        }

        $max = max(array_map('strlen', array_keys($this->headers))) + 1;
        $content = '';
        ksort($this->headers);
        foreach ($this->headers as $name => $values) {
            $name = implode('-', array_map('ucfirst', explode('-', $name)));
            foreach ($values as $value) {
                $content .= sprintf("%-{$max}s %s\r\n", $name.':', $value);
            }
        }

        return $content;
    }


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
     * @return Abonnement
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
     * Set espace
     *
     * @param integer $espace
     * @return Abonnement
     */
    public function setEspace($espace)
    {
        $this->espace = $espace;
    
        return $this;
    }

    /**
     * Get espace
     *
     * @return integer 
     */
    public function getEspace()
    {
        return $this->espace;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     * @return Abonnement
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    
        return $this;
    }

    /**
     * Get prix
     *
     * @return integer 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    public function getUniqueName()
	{
	    return sprintf('%s - %s', $this->nom, $this->prix . '€/mois');
	}

}