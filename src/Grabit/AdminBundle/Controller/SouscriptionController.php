<?php

namespace Grabit\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Grabit\AdminBundle\Entity\Souscription;
use Grabit\AdminBundle\Form\SouscriptionType;

/**
 * Souscription controller.
 *
 */
class SouscriptionController extends Controller
{
    /**
     * Lists all Souscription entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AdminBundle:Souscription')->findAll();

        return $this->render('AdminBundle:Souscription:index.html.twig', array(
            'entities'   => $entities,
	    'page_title' => 'Liste des souscriptions'
        ));
    }

    /**
     * Finds and displays a Souscription entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AdminBundle:Souscription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Souscription".');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Souscription:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
	    'page_title' => 'Souscription'
	    ));
    }

    /**
     * Displays a form to create a new Souscription entity.
     *
     */
    public function newAction()
    {
        $entity = new Souscription();
        $form   = $this->createForm(new SouscriptionType(), $entity);

        return $this->render('AdminBundle:Souscription:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
	    'page_title' => 'Création d\'une souscription'
        ));
    }

    /**
     * Creates a new Souscription entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Souscription();
        $form = $this->createForm(new SouscriptionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('souscription_show', array('id' => $entity->getId())));
        }

        return $this->render('AdminBundle:Souscription:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
	    'page_title' => 'Création d\'une souscription'
        ));
    }

    /**
     * Displays a form to edit an existing Souscription entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnements = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Abonnement')->findAll();

        $entity = $em->getRepository('AdminBundle:Souscription')->find($id);
	$idUtilisateur = $entity->getIdUtilisateur() ;
	$utilisateur = $em->getRepository('AdminBundle:Utilisateur')
		->findOneBy(array('id' => $idUtilisateur));
        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Souscription".');
        }

        $editForm = $this->createForm(new SouscriptionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:Souscription:edit.html.twig', array(
            'entity'      => $entity,
	    'utilisateur' => $utilisateur,
            'edit_form'   => $editForm->createView(),
	    'page_title'  => 'Éditer une souscription',
	    'abonnements' => $abonnements,
	    'id'          => $id
        ));
    }

    /**
     * Edits an existing Souscription entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $abonnements = $this->getDoctrine()->getManager()->getRepository('AdminBundle:Acces')->findAll();
        $entity = $em->getRepository('AdminBundle:Souscription')->find($id);
	$idUtilisateur = $entity->getIdUtilisateur() ;
	$utilisateur = $em->getRepository('AdminBundle:Utilisateur')
		->findOneBy(array('id' => $idUtilisateur));

        if (!$entity) {
            throw $this->createNotFoundException('Impossible de trouver l\'entité "Souscription".');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SouscriptionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('souscription_show', array('id' => $id)));
        }

        return $this->render('AdminBundle:Souscription:edit.html.twig', array(
            'entity'      => $entity,
	    'utilisateur' => $utilisateur,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
	    'page_title'  => 'Éditer une souscription',
	    'abonnements' => $abonnements
        ));
    }

    /**
     * Deletes a Souscription entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AdminBundle:Souscription')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de trouver l\'entité "Souscription".');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('souscription'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
