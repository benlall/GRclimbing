<?php

namespace AppBundle\Service;

class Mailer
{
    private $mailer;
    private $templating;
    private $fromGR;
    private $toGR;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, $fromGR, $toGR)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->fromGR = $fromGR;
        $this->toGR = $toGR;
    }

     public function sendEmailNewUser($toUser, $subject, $fullname, $password)
    {
        $mail = new \Swift_Message;

        $mail
        ->setFrom($this->fromGR)
        ->setTo($toUser)
        ->setSubject($subject)
        ->setBody($this->templating->render('admin/email/new_user.html.twig', [
            'fullname' => $fullname,
            'password' => $password]))
        ->setContentType('text/html');

        $this->mailer->send($mail);
    }

    public function sendEmailContactForm($from, $contactFirstname, $contactLastname, $contactEmail, $subject, $contactPhone, $contactQuestion)
    {
        $mail = new \Swift_Message;

        $mail
            ->setFrom($from)
            ->setTo($this->toGR)
            ->setSubject($subject)
            ->setBody($this->templating->render('admin/email/contact_form.html.twig', [
                'firstname' => $contactFirstname,
                'lastname' => $contactLastname, 'email' => $contactEmail, 'phone' => $contactPhone, 'question' => $contactQuestion, ]), 'text/html');

        $this->mailer->send($mail);
    }

    public function sendEmailToChangePassword($toUser, $subject, $fullname, $token)
    {
        $mail = new \Swift_Message;


        $mail
            ->setFrom($this->fromGR)
            ->setTo($toUser)
            ->setSubject($subject)
            ->setBody($this->templating->render('admin/email/change_password.html.twig', [
                'fullname' => $fullname,
                'token' => $token]), 'text/html');

        $this->mailer->send($mail);
    }

}
