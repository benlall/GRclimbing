<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Licensee;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Licensee controller.
 *
 * @Route("licensee")
 */
class LicenseeController extends Controller
{
    /**
     * Lists all licensee entities.
     *
     * @Route("/", name="licensee_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $licensees = $em->getRepository('AppBundle:Licensee')->findAll();

        return $this->render('licensee/index.html.twig', array(
            'licensees' => $licensees,
        ));
    }

    /**
     * Creates a new licensee entity.
     *
     * @Route("/new", name="licensee_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $licensee = new Licensee();
        $form = $this->createForm('AppBundle\Form\LicenseeType', $licensee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($licensee);
            $em->flush();

            return $this->redirectToRoute('licensee_show', array('id' => $licensee->getId()));
        }

        return $this->render('licensee/new.html.twig', array(
            'licensee' => $licensee,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a licensee entity.
     *
     * @Route("/{id}", name="licensee_show")
     * @Method("GET")
     */
    public function showAction(Licensee $licensee)
    {
        $deleteForm = $this->createDeleteForm($licensee);

        return $this->render('licensee/show.html.twig', array(
            'licensee' => $licensee,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing licensee entity.
     *
     * @Route("/{id}/edit", name="licensee_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Licensee $licensee)
    {
        $deleteForm = $this->createDeleteForm($licensee);
        $editForm = $this->createForm('AppBundle\Form\LicenseeType', $licensee);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('licensee_edit', array('id' => $licensee->getId()));
        }

        return $this->render('licensee/edit.html.twig', array(
            'licensee' => $licensee,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a licensee entity.
     *
     * @Route("/{id}", name="licensee_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Licensee $licensee)
    {
        $form = $this->createDeleteForm($licensee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($licensee);
            $em->flush();
        }

        return $this->redirectToRoute('licensee_index');
    }

    /**
     * Creates a form to delete a licensee entity.
     *
     * @param Licensee $licensee The licensee entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Licensee $licensee)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('licensee_delete', array('id' => $licensee->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
