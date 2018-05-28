<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/redirection", name="redirection")
     */
    public function redirectionAfterLogin()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $connectedUser = $this->getUser();

        if (!$connectedUser->getStaff()) {
            return $this->redirectToRoute('climbers', ['connectedUser' => $connectedUser]);
        }

        return $this->redirectToRoute('admin', ['connectedUser' => $connectedUser]);
    }


}
