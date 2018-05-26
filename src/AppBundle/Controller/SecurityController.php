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
     * @Route("/check", name="login_check")
     */
    public function loginCheck()
    {
        $user = $this->getUser();
       // return $this->render('default/climbers.html.twig', ['user' => $user]);
        return $this->render('admin/index.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/redirection", name="redirection")
     */
    public function redirectionAfterLogin()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        /*if (!$user->getStaff()) {
            return $this->redirectToRoute('climbers', ['user' => $user]);
        }

        return $this->redirectToRoute('admin', ['user' => $user]);
*/return $this->render('admin/index.html.twig', ['user' => $user]);

    }


}
