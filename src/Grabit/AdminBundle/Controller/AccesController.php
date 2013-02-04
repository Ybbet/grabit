<?php

namespace Grabit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Grabit\AdminBundle\Entity\Acces;
use Grabit\AdminBundle\Form\AccesType;
use Grabit\AdminBundle\Entity\Souscription;
use Grabit\AdminBundle\Form\SouscriptionType;

/**
 * Acces controller.
 *
 */
class AccesController extends Controller
{
    /**
     * Lists all Acces entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Acces')->findAll();

        return $this->render('AdminBundle:Acces:index.html.twig', array(
            'entities'    => $entities,
	    'page_title'  => 'Liste des accès'
        ));
    }

    /**
     * Finds and displays a Acces entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Acces')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Accès".');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Acces:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
	    'page_title'  => 'Fiche d\'accès'
	    ));
    }

    /**
     * Displays a form to create a new Acces entity.
     *
     */
    public function newAction($id)
    {
	/*/** L'id est obligatoire. 
	 * On la reçu par la création de la table utilisateur.
	 * cf. etape 1, création de l'utilisateur, 
	 * etape 2, création de l'accès (newAction), 
	 * etape 3, on crée automatiquement la souscription (Acces -> createAction)
	 */
        $entity = new Acces();
	$entity->setIdUtilisateur($id) ;
        $form   = $this->createForm(new AccesType(), $entity);

        return $this->render('AdminBundle:Acces:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
	    'page_title' => 'Code de connexion',
	    'etape'      => 'Étape 2/2'
        ));
    }

    /**
     * Creates a new Acces entity.
     *
     */
    public function createAction(Request $request)
    {
	/** Là, on s'occupe de la requête pour l'accès
	 * On est à l'étape 2
	 */
        $entity  = new Acces();
	$entity->setConnexion(new \DateTime('now')) ;
	$entity->setPassword(sha1($entity->getPassword())) ;
        $form = $this->createForm(new AccesType(), $entity);
        $form->bind($request);
	
	/**
	 * On est à l'étape 3, on va crée la souscription associée à l'id_utlisateur
	 * On va utiliser les fonction setIdUtilisateur, setIdAbonnement 
	 * et setFinValidite de Souscription()
	 */
        $entitySouscription  = new Souscription();
	$entitySouscription->setIdUtilisateur($entity->getIdUtilisateur()) ;
	/** par défaut, l'utilisateur souscrit à l'abonnement de base id=1 :
	 * 
	 * Remarque : on pourrait faire une requête sur la table Abonnement pour
	 * avoir l'id de la première ligne (ORDER BY 'id')
	 * Cela permettrait de toujours avoir une cohérence avec la table abonnement
	 * Ou sinon, toujours sur la table abonnement, voir uniquement ceux ayant un prix=0
	 * SELECT * FROM abonnement WHERE prix=0 ORDER BY id LIMIT (0,1)
	 * 
	 */
	$entitySouscription->setIdAbonnement(1) ;
	// On crée un variable qui a prendre la date d'aujourd'hui :
	$dateValidite = new \DateTime('now') ;
	// On incrémente cette date de 30 jours (durée d'un abonnement et de son renouvellement)
	$dateValidite->add(new \DateInterval('P30D')) ;
	// On sette la date de fin de validité avec notre variable de date :
	$entitySouscription->setFinValidite($dateValidite) ;


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
	    // schéma classique, on persiste $entity de notre requête
            $em->persist($entity);
	    // on persiste maintenant notre nouvelle souscription :
	    $em->persist($entitySouscription) ;
	    // on ajoute tout ça à la BDD :
            $em->flush();

            return $this->redirect($this->generateUrl('utilisateur_show', array('id' => $entity->getIdUtilisateur())));
        }

        return $this->render('AdminBundle:Acces:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
	    'page_title' => 'Création d\'un utilisateur'
        ));
    }

    /**
     * Displays a form to edit an existing Acces entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Acces')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Accès".');
        }

        $editForm = $this->createForm(new AccesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Acces:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
	    'page_title'  => 'Éditer les codes d\'accès'
        ));
    }

    /**
     * Edits an existing Acces entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Acces')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Accès".');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AccesType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('utilisateur_show', array('id' => $entity->getIdUtilisateur())));
        }

        return $this->render('AdminBundle:Acces:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
	    'page_title'  => 'Éditer les codes d\'accès'
        ));
    }

    /**
     * Deletes a Acces entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Acces')->find($id);
	    // On récupère l'id_utilisateur
	    $idUtilisateur = $entity->getIdUtilisateur() ;
            if (!$entity) {
                throw $this->createNotFoundException('Impossible de trouver l\'entité "Accès".');
            }

            $em->remove($entity);
	    /**
	     * On récupère l'accès et la souscription selon id_utlisateur
	     */
	    $utilisateur  = $em->getRepository('AdminBundle:Utilisateur')
		    ->find($idUtilisateur) ;
	    $souscription = $em->getRepository('AdminBundle:Souscription')
		    ->findOneBy(array('id_utilisateur' => $idUtilisateur));
	    /**
	     * On supprime dans l'ordre :
	     * - le compte utilisateur ;
	     * - l'entrée acces associé ;
	     * - l'entrée souscription associé ;
	     */
	    $em->remove($utilisateur) ;
	    $em->remove($souscription) ;
	    $em->flush() ;
        } 

        return $this->redirect($this->generateUrl('acces'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    public function blockAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Acces')->findOneBy(array('id_utilisateur' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Accès".');
        }

	$entity->setBloque(true) ;
        $em->flush();

            return $this->redirect($this->generateUrl('utilisateur'));

    }

    public function unblockAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Acces')->findOneBy(array('id_utilisateur' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Accès".');
        }

	$entity->setBloque(false) ;
        $em->flush();

            return $this->redirect($this->generateUrl('utilisateur'));

    }

}
