<?php

namespace DEPI\ProyectosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use DEPI\ProyectosBundle\Entity\Proyectos;
use DEPI\ProyectosBundle\Form\ProyectosType;

/**
 * Proyectos controller.
 *
 * @Route("/proyectos")
 */
class ProyectosController extends Controller
{

    /**
     * Lists all Proyectos entities.
     *
     * @Route("/", name="proyectos")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ProyectosBundle:Proyectos')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Proyectos entity.
     *
     * @Route("/", name="proyectos_create")
     * @Method("POST")
     * @Template("ProyectosBundle:Proyectos:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Proyectos();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('proyectos'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Proyectos entity.
    *
    * @param Proyectos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Proyectos $entity)
    {
        $form = $this->createForm(new ProyectosType(), $entity, array(
            'action' => $this->generateUrl('proyectos_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }

    /**
     * Displays a form to create a new Proyectos entity.
     *
     * @Route("/new", name="proyectos_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Proyectos();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Proyectos entity.
     *
     * @Route("/{id}/edit", name="proyectos_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProyectosBundle:Proyectos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proyectos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Proyectos entity.
    *
    * @param Proyectos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Proyectos $entity)
    {
        $form = $this->createForm(new ProyectosType(), $entity, array(
            'action' => $this->generateUrl('proyectos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing Proyectos entity.
     *
     * @Route("/{id}", name="proyectos_update")
     * @Method("PUT")
     * @Template("ProyectosBundle:Proyectos:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ProyectosBundle:Proyectos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Proyectos entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('proyectos'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Proyectos entity.
     *
     * @Route("/{id}", name="proyectos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ProyectosBundle:Proyectos')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Proyectos entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('proyectos'));
    }

    /**
     * Creates a form to delete a Proyectos entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('proyectos_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }
}
