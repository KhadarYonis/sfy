<?php

namespace AppBundle\Form;


use AppBundle\Entity\Country;
use AppBundle\Entity\Language;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
         * add : ajouter un champ au formulaire
         * paramètre :
         *       - nom du champ récupéré par la vue
         *       - type du champ
         *       - options :
         *              - contraintes de validation
         */
        $builder
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi votre prénom"
                    ]),
                    new Regex([
                        'message' => "Votre prénom n'est pas valide",
                        'pattern' => "/^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ.]+(([',. -][a-zA-Z áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ.])?[a-zA-Z]*)*$/"
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi votre nom"
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi votre mail"
                    ]),
                    new Email([
                        'message' => "Votre email est incorrect",
                        'checkHost' => true,
                        'checkMX' => true
                    ])
                ]
            ])
            ->add('message', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas saisi votre message"
                    ])
                ]
            ])
            /*
             * champ relié à une entité : EntityType
             * placeholder : permet de definir la propriété de l'entité à afficher dans le champ
             */
            ->add('country', EntityType::class, [
                'class'  => Country::class,
                'choice_label' => 'name',
                'placeholder' => 'Choissiez le pays',
                'constraints' => [
                    new NotBlank([
                        'message' => "Vous n'avez pas sélectionné votre pays"
                    ])
                ]
            ])
            /*
             * gestion de l'affichage des champs multiples
             *      expanded : afficher plusieurs champs
             *      multiple : sélectionner plusieurs valeurs
             *
             *      select : expanded => true, multiple => false (par défaut)
             *      radio : expanded => true, multiple => false
             *      checkbox : expanded => true, multiple => true
             */
            ->add('languages', EntityType::class, [
                'class' => Language::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'label_attr' => array(
                    'class' => 'checkbox-inline'
                ),
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'minMessage' => "Vous devez sélectionner au minumun {{ limit }} langue."
                    ])
                ]

            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_contact';
    }


}
