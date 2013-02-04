<?php

namespace Grabit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Grabit\AdminBundle\Entity\Utilisateur;
use Grabit\AdminBundle\Form\UtilisateurType;


/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller
{
    /**
     * Lists all Utilisateur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Utilisateur')->findAll();
	$acces = $em->getRepository('AdminBundle:Acces')->findAll() ;

        return $this->render('AdminBundle:Utilisateur:index.html.twig', array(
            'entities' => $entities,
	    'acces'    => $acces,
	    'page_title' => 'Les utilisateurs'
        ));
    }

    /**
     * Finds and displays a Utilisateur entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Utilisateur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Utilisateur".');
        }

	/**
	 * On récupère l'accès et la souscription selon id_utlisateur=$id
	 */
	$acces = $em->getRepository('AdminBundle:Acces')
		->findOneBy(array('id_utilisateur' => $id));

	$souscription = $em->getRepository('AdminBundle:Souscription')
		->findOneBy(array('id_utilisateur' => $id));
	$abonnements = $em->getRepository('AdminBundle:Abonnement') 
		->findAll();

	$deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Utilisateur:show.html.twig', array(
            'entity'      => $entity,
	    'acces'       => $acces,
	    'souscription' => $souscription,
	    'abonnements'  => $abonnements,
            'delete_form' => $deleteForm->createView(),
	    'page_title'  => 'Fiche utlisateur',
	    ));
    }

    /**
     * Displays a form to create a new Utilisateur entity.
     *
     */
    public function newAction()
    {
        $entity = new Utilisateur();
        $form   = $this->createForm(new UtilisateurType(), $entity);

        return $this->render('AdminBundle:Utilisateur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
	    'page_title' => 'Ajouter un nouvel utilisateur',
	    'etape'      => 'Étape 1/2'
        ));

    }

    /**
     * Creates a new Utilisateur entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Utilisateur();
        $form   = $this->createForm(new UtilisateurType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('utilisateur_acces', array('id' => $entity->getId())));
        }

        return $this->render('AdminBundle:Utilisateur:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
	    'page_title' => 'Ajouter un nouvel utilisateur <small>étape 1/2</small>'
        ));
    }

    /**
     * Displays a form to edit an existing Utilisateur entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Utilisateur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Utilisateur".');
        }

        $editForm = $this->createForm(new UtilisateurType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Utilisateur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
	    'page_title'  => 'Éditer la fiche de l\'utilisateur'
        ));
    }

    /**
     * Edits an existing Utilisateur entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Utilisateur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Utilisateur".');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UtilisateurType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('utilisateur_show', array('id' => $id)));
        }

        return $this->render('AdminBundle:Utilisateur:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
	    'page_title'  => 'Editer un utlisateur'
        ));
    }

    /**
     * Deletes a Utilisateur entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Utilisateur')->find($id);
	    // On récupère l'id_utilisateur
	    $idUtilisateur = $entity->getId() ;
            if (!$entity) {
                throw $this->createNotFoundException('Impossible de trouver l\'entité "Utilisateur".');
            }

	    $em->remove($entity);
	    /**
	     * On récupère l'accès et la souscription selon id_utlisateur=$id
	     */
	    $acces        = $em->getRepository('AdminBundle:Acces')
		    ->findOneBy(array('id_utilisateur' => $idUtilisateur));
	    $souscription = $em->getRepository('AdminBundle:Souscription')
		    ->findOneBy(array('id_utilisateur' => $idUtilisateur));
	    /**
	     * On supprime dans l'ordre :
	     * - le compte utilisateur ;
	     * - l'entrée acces associé ;
	     * - l'entrée souscription associé ;
	     */
            $em->remove($acces);
            $em->remove($souscription);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('utilisateur'));
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

            return $this->redirect($this->generateUrl('acces'));

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

            return $this->redirect($this->generateUrl('acces'));

    }


}
