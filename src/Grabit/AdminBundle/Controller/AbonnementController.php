<?php

namespace Grabit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Grabit\AdminBundle\Entity\Abonnement;
use Grabit\AdminBundle\Form\AbonnementType;

/**
 * Abonnement controller.
 *
 */
class AbonnementController extends Controller
{
    /**
     * Lists all Abonnement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Abonnement')->findAll();

        return $this->render('AdminBundle:Abonnement:index.html.twig', array(
            'entities' => $entities,
	    'page_title' => 'Liste des abonnements'
        ));
    }

    /**
     * Finds and displays a Abonnement entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
	
        $entity = $em->getRepository('AdminBundle:Abonnement')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Abonnement entity.');
        }

	$souscriptions = $this->getDoctrine()
		->getRepository('AdminBundle:Souscription')
		->findAll();

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Abonnement:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
	    'page_title'  => 'Fiche d\'abonnement',
	    'souscriptions'=> $souscriptions
	    ));
    }

    /**
     * Displays a form to create a new Abonnement entity.
     *
     */
    public function newAction()
    {
        $entity = new Abonnement();
        $form   = $this->createForm(new AbonnementType(), $entity);

        return $this->render('AdminBundle:Abonnement:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
	    'page_title' => 'Ajout d\'un abonnement'
        ));
    }

    /**
     * Creates a new Abonnement entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Abonnement();
        $form = $this->createForm(new AbonnementType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('abonnement_show', array('id' => $entity->getId())));
        }

        return $this->render('AdminBundle:Abonnement:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
	    'page_title' => 'Ajout d\'un abonnement'
        ));
    }

    /**
     * Displays a form to edit an existing Abonnement entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Abonnement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Abonnement entity.');
        }

        $editForm = $this->createForm(new AbonnementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Abonnement:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
	    'page_title' => 'Éditer un abonnement'
        ));
    }

    /**
     * Edits an existing Abonnement entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Abonnement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Abonnement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AbonnementType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('abonnement_show', array('id' => $id)));
        }

        return $this->render('AdminBundle:Abonnement:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
	    'page_title' => 'Editer un abonnement'
        ));
    }

    /**
     * Deletes a Abonnement entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Abonnement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Abonnement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('abonnement'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
