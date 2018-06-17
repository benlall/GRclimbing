<?php

namespace AppBundle\Controller;

use AppBundle\Model\Contact;
use AppBundle\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;


class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
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
     * @Method({"GET","POST"})
     */
    public function contactAction(Request $request, Mailer  $mailer)
    {
        $contact = new Contact();

        $form = $this->createForm('AppBundle\Form\ContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mailer->sendEmailContactForm(
                $contact->getEmail(),
                $contact->getFirstname(),
                $contact->getLastname(),
                $contact->getEmail(),
                'Demande d\'information Glace & Roc',
                $contact->getPhone(),
                $contact->getQuestion()
            );

            $this->addFlash('success', 'Votre message a bien été envoyé.');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/contact.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}
