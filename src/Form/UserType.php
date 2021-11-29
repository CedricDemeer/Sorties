<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'pseudo',
                'attr' => ['class' => 'form-control']
            ])
            ->add('Prenom', TextType::class, [
                'label' => 'Prenom',
                'attr' => ['class'  => 'form-control']
            ])
            ->add('Nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class'  => 'form-control']
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Telephone',
                'attr' => ['class'  => 'form-control']
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your email',
                    ]),
                ],
                'attr' => ['class'  => 'form-control']
            ])

            /*->add('password', RepeatedType::class, [
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

            ])*/
            ->add('campus', EntityType::class, array(
                'class' => 'App\Entity\Campus',
                'choice_label' => 'nom',
                'attr' => ['class'  => 'form-select']
            ))
            ->add('photoFile', FileType::class, [
                'label' => 'Photo',
                'required' => false,
                'empty_data' => new \Symfony\Component\HttpFoundation\File\File('uploads/images/profils/profil-vide.png'),
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPG or PNG',
                    ])
                ],
                'attr' => ['class'  => 'form-control form-control-sm']
            ])

            /*->add('SupprimerPhoto', CheckboxType::class, [
                'mapped' => false,
                'required' => false
                ])*/

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}