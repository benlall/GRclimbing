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
     * @Route("/", name="climbers")
     * @Method("GET")
     */
    public function climbersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findByActivePrivatePost();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $connectedUser = $this->getUser();

        return $this->render('default/climbers.html.twig', [
            'posts' => $posts,
            'connectedUser' => $connectedUser,
        ]);
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="show_climber")
     * @Method("GET")
     */
    public function showClimber(User $user)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $connectedUser = $this->getUser();

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $connectedUser = $this->getUser();

        return $this->render('climber/show.html.twig', [
            'user' => $user,
            'connectedUser' => $connectedUser,
        ]);
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="edit_climber")
     * @Method({"GET", "POST"})
     */
    public function editClimber(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteFormClimber($user);
        $editForm = $this->createForm('AppBundle\Form\ClimberType', $user);
        $editForm->handleRequest($request);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $connectedUser = $this->getUser();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('show_climber', array('id' => $user->getId()));
        }

        return $this->render('climber/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'connectedUser' => $connectedUser,
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
        $form = $this->createDeleteFormClimber($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('climbers');
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteFormClimber(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_climber', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
