<?php

namespace AppBundle\Model;

use Symfony\Component\Validator\Constraints;


/**
 *
 */
class Contact
{
    /**
     * @Constraints\NotBlank(message = "Le prénom doit être rempli")
     */
    private $firstname;
    
    /**
     * @Constraints\NotBlank(message = "Le nom doit être rempli")
     */
    private $lastname;

    /**
    * @Constraints\NotBlank(message = "L'email doit être rempli")
    * @Constraints\Email(message = "L'email n'est pas valide")
    */
    private $email;
    
    /**
     * @Constraints\Regex(pattern = "/0[1-9][0-9]{8}/", message = "Le numéro de téléphone doit comporter 10 chiffres")
     */
    private $phone;
    
    /**
     * @Constraints\NotBlank(message = "Le message doit être rempli")
     */
    private $question;
    
    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }
    
    /**
     * @param mixed $firstname
     * @return Contact
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     * @return Contact
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param mixed $email
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * @param mixed $phone
     * @return Contact
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }
    
    /**
     * @param mixed $question
     * @return Contact
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }
    
}