<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Admin controller.
 *
 * @Route("admin")
 */
class AdminController extends Controller
{

    /**
     * Lists all post entities.
     *
     * @Route("/", name="admin")
     * @Method("GET")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', array());
    }

    /**
     * Lists all posts entities.
     *
     * @Route("/posts", name="list_posts")
     * @Method("GET")
     */
    public function postList()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AppBundle:Post')->findAll();

        return $this->render('admin/post/list.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/posts/new", name="new_post")
     * @Method({"GET", "POST"})
     */
    public function newPost(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('AppBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('show_post', array('id' => $post->getId()));
        }

        return $this->render('admin/post/new.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a post entity.
     *
     * @Route("/posts/{id}", name="show_post")
     * @Method("GET")
     */
    public function showPost(Post $post)
    {
        return $this->render('admin/post/show.html.twig', array(
            'post' => $post,
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     * @Route("/posts/{id}/edit", name="edit_post")
     * @Method({"GET", "POST"})
     */
    public function editPost(Request $request, Post $post)
    {
        $deleteForm = $this->createDeleteFormPost($post);
        $editForm = $this->createForm('AppBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('edit_post', array('id' => $post->getId()));
        }

        return $this->render('admin/post/edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/posts/{id}/delete", name="delete_post")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteFormPost($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('list_posts');
    }

    /**
     * Creates a form to delete a post entity.
     *
     * @param Post $post The post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteFormPost(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_post', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Lists all user entities.
     *
     * @Route("/users", name="list_users")
     * @Method("GET")
     */
    public function usersList()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('admin/user/list.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity : licensee or staff
     *
     * @Route("/users/new", name="new_user")
     * @Method({"GET", "POST"})
     */
    public function newUser(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.password_encoder');
            $encoder = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoder);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('show_user', array('id' => $user->getId()));
        }

        return $this->render('admin/user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/users/{id}", name="show_user")
     * @Method("GET")
     */
    public function showUser(User $user)
    {
        $deleteForm = $this->createDeleteFormUser($user);

        return $this->render('admin/user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/users/{id}/edit", name="edit_user")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteFormUser($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('edit_user', array('id' => $user->getId()));
        }

        return $this->render('admin/user/edit.html.twig', array(
            'User' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/users/{id}/delete", name="delete_user")
     * @Method("DELETE")
     */
    public function deleteUser(Request $request, User $user)
    {
        $form = $this->createDeleteFormUser($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('list_users');
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteFormUser(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_user', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
