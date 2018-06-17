<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre de la news :'])
            ->add('content', TextareaType::class, ['label' => 'Contenu :'])
            ->add('publicPost', ChoiceType::class, [
                'choices' => [
                    'non' => '0',
                    'oui' => '1'],
                'expanded' => true,
                'label' => 'News publique :'
            ])
            ->add('activePost', ChoiceType::class, [
                'choices' => [
                    'non' => '0',
                    'oui' => '1'],
                'expanded' => true,
                'label' => 'News active :'
            ])
            ->add('imgLink', TextType::class, ['label' => 'Nom de l\'image : assets/upload/nom_de_l\'image.jpg']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_post';
    }


}
