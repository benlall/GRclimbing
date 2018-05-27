<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Climber controller.
 *
 * @Route("user/climbers")
 */
class ClimberController extends Controller
{

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="show_climber")
     * @Method("GET")
     */
    public function showClimber(User $user)
    {
        return $this->render('climber/show.html.twig', array('user' => $user));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="edit_climber")
     * @Method({"GET", "POST"})
     */
    public function editClimber(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteFormPost($user);
        $editForm = $this->createForm('AppBundle\Form\ClimberType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_climber', array('id' => $user->getId()));
        }

        return $this->render('climber/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}/delete", name="delete_climber")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteFormPost($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('climbers');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteFormPost(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_post', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
