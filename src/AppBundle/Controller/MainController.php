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
     * @Route("/{id}", name="homepage" , requirements={"id" = "\d+"})
     */
    public function indexAction($id)
    {
        // post : not with id but with latest public id
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository(Post::class)->find($id);

        return $this->render('default/index.html.twig', array(
            'post' => $post
        ));
    }

    /**
     * @Route("/contact", name="contact")
     * @Method("GET")
     */
    public function contactAction()
    {
        return $this->render('default/contact.html.twig');
    }

    /**
     * @Route("/user/climbers", name="climbers")
     * @Method("GET")
     */
    public function climbersAction()
    {
        return $this->render('default/climbers.html.twig');
    }

}
