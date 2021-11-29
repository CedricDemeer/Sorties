<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Categorie;
use App\Modele\FiltreSortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('campus', EntityType::class, [
                'label' => 'Campus',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'class'=>Campus::class,
                'choice_label'=>'nom',
                'attr' => [
                    'class' => 'form-select'
                ],
                'required'=>false

            ])

            ->add('categorie', EntityType::class, [
                'label' => 'Catégorie',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'class'=>Categorie::class,
                'choice_label'=>'libelle',
                'attr' => [
                    'class' => 'form-select'
                ],
                'required'=>false

            ])


            ->add('champSaisie', TextType::class, [
                'label' => 'Le nom de la sortie contient',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => false,
                'data' => ''
            ])

            ->add('dateintervalmin', DateType::class, [
                'label' => 'Entre',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'required' => false,
                'format' => 'dd MM yyyy',
                'placeholder' => [
                    'year' => 'Année',
                    'month' => 'Mois',
                    'day'=> 'Jour'
                ],

                'years'=>range(21,25)
            ])

            ->add('dateintervalmax', DateType::class, [
                'label' => 'et',

                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'required' => false,
                'format' => 'dd MM yyyy',
                'placeholder' => [
                    'year' => 'Année',
                    'month' => 'Mois',
                    'day'=> 'Jour'
                ],
                'years'=>range(21,25),
            ])
            ->add('sortieOrga', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur/trice',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'required' => false,
                'value'=>1
            ])

            ->add('sortieInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis inscrit/e',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'required' => false,
                'value'=>2
            ])
            ->add('sortieNonInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'required' => false,
                'value'=>3
            ])
            ->add('sortiePassee', CheckboxType::class, [

                'required' => false,
                'label' => 'Sorties passées',
                'label_attr' => [
                    'class' => 'col-form-label'
                ],
                'value'=>4
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FiltreSortie::class,
        ]);
    }
}
