<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class NewPasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe ne sont pas identiques',
                'first_options' => [
                    'label' => 'Votre nouveau mot de passe :',
                    //TODO Remettre une REGEX pour définir le MDP
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe :',
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }

    /**
     * {@inheritdoc} getName() is now deprecated
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }
}
