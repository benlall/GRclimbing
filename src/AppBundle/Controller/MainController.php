<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Post;

class MainController extends Controller
{
    /**
     * @Route("/{id}", name="homepage")
     */
    public function indexAction($id)
    {
        // post : not with id but with latest id
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->findOneById($id);

        return $this->render('default/index.html.twig', array(
            'post' => $post
        ));
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        return $this->render('default/login.html.twig');
    }

}
