<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\Entity\User;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }


    /**
     * @Route("/success", name="success_login")
     */
    public function successLogin()
    {
        $user = $this->getUser();

        if(!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('climbers', ['user' => $user]);
        }

        return $this->redirectToRoute('admin', ['user' => $user]);

    }


}
