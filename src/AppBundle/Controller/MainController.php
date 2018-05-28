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
     * @Route("/", name="homepage" , requirements={"id" = "\d+"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Post::class)->findByActivePublicPost();

        return $this->render('default/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @Method("GET")
     */
    public function contactAction()
    {
        return $this->render('default/contact.html.twig');
    }

}
