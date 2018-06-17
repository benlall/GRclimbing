<?php


namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\VerifyEmailType;
use AppBundle\Form\NewPasswordType;
use AppBundle\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ForgottenPasswordController extends Controller
{

    /**
     * Display send your email to change password page
     * @Route("/reset_password", name="reset_password")
     * @Method({"GET", "POST"})
     */
    public function sendEmail(Request $request, Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(VerifyEmailType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $userForm = $form->getData();
            $emailForm = $userForm->getEmail();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy([
                'email' => $emailForm
            ]);

            if ($user) {
                $user->setToken(uniqid());
                $em->persist($user);
                $em->flush();

                $mailer->sendEmailToChangePassword(
                    $user->getEmail(),
                    'Lien pour changer de mot de passe',
                    $user->getFullname(),
                    $user->getToken()
                    );

                $this->addFlash('success', 'Un email contenant un lien pour changer votre mot de passe vous a été envoyé.');
                return $this->redirectToRoute('login');
            } else {
                $this->addFlash('error', 'Cet email n\'est pas connu de notre service. Veuillez vérifier que l\'adresse saisie est correcte.');
                return $this->redirectToRoute('reset_password');
            }
        };
        return $this->render('/climber/send_email_for_password.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Display write your new password page
     * @Route("/change_password/{token}", name="change_password")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(NewPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = $request->get('token');
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy([
                'token' => $token
            ]);

            if ($user) {
                $hashedPassword = $passwordEncoder->encodePassword($user, $form->getData()->getPassword());
                $user->setPassword($hashedPassword);
                $user->setToken(null);
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'La modification de votre mot de passe a bien été prise en compte.');

            return $this->redirectToRoute('login');
            } else {
                $this->addFlash('error', 'Vous n\'avez pas l\'autorisation de procéder à ce changement de mot de passe. Veuillez recommencer la procédure.');            }
        }
        return $this->render('/climber/change_password.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
