<?php

namespace Grabit\AdminBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SouscriptionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SouscriptionRepository extends EntityRepository
{
    public function findIdUtilisateur()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT * FROM AdminBundle:Souscription p WHERE p.name ASC')
            ->getResult();
    }}
