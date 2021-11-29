<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your email',
                    ])
                ],
                'attr' => ['class'  => 'form-control']
            ])
            //->add('roles')
            //->add('password')
            ->add('Nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class'  => 'form-control']
            ])
            ->add('Prenom', TextType::class, [
                'label' => 'Prenom',
                'attr' => ['class'  => 'form-control']
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'pseudo',
                'attr' => ['class' => 'form-control']
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Telephone',
                'attr' => ['class'  => 'form-control']
            ])
            ->add('administrateur')
            ->add('actif')
            ->add('campus', EntityType::class, array(
                'class' => 'App\Entity\Campus',
                'choice_label' => 'nom',
                'attr' => ['class'  => 'form-select']
            ))
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options' => ['label' => 'Password',
                    'attr' => ['class'  => 'form-control']
                ],
                'second_options' => ['label' => 'Repeat Password',
                    'attr' => ['class'  => 'form-control']
                ],
                'mapped' => false

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
