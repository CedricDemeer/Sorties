<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Categorie;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $today = new \DateTime();
        $dt= $today->format('Y-m-d\TH:i');
        $date = $today -> format ('Y-m-d');
        $annee = date_format($today, 'Y');
        $mois = date_format($today, 'M');
        $jour = date_format($today, 'd');

        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('dateHeureDebut', DateTimeType::class, [
                'label' => 'Date et Heure de la sortie',
                'widget' => 'single_text',

                /*'widget'=> 'choice',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'placeholder' => [
                    'year' => $annee, 'month' => $mois, 'day' => $jour,
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => '00',
                ],*/
                'attr' => [
                    'value' => $dt,
                ]

            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée de la sortie (en minutes)',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
            ->add('dateLimiteInscription', DateType::class, [
                'label' => 'Date limite d\'inscription à la sortie',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'value' => $date,
                ]
                /*'widget'=> 'choice',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'placeholder' => [
                    'year' => $annee, 'month' => $mois, 'day' => $jour,
                ],
                'years'=>range(21,25)*/
            ])
            ->add('nbInscriptionMax', IntegerType::class, [
                'label' => 'Nbr de participants maximum',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'label' => 'Catégorie',
                'choice_label' => 'libelle',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'label' => 'Campus',
                'choice_label' => 'nom',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'label' => 'Lieu',
                'choice_label' => 'nom',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'attr' => [
                    'class' => 'form-select'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
