<?php

namespace App\Form;

use App\Entity\EquipmentCategory;
use App\Entity\EquipmentSubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentSubCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Nom de la sous-catégorie'
            ])
            ->add('parentCategory', EntityType::class,[
                'label'=>'Catégorie Parente',
                'class'=>EquipmentCategory::class,
                'choice_label'=>'category'
            ])
            ->add('periodicControlPrice', TextType::class,[
                'label'=>'Prix de contrôle périodique(€)'
            ])
            ->add('mESControlPrice', TextType::class,[
                'label'=>'Prix de contrôle de mise en service(€)',
                'required'=>false
            ])
            ->add('rMESControlPrice', TextType::class,[
                'label'=>'Prix de contrôle de remise en service(€)',
                'required'=>false
            ])
            ->add('periodicity', TextType::class,[
                'label'=>'Périodicité des contrôles (mois)'
            ])
            ->add('ajouter', SubmitType::class,[
                'label'=>'Ajouter la nouvelle catégorie',
                'attr'=>[
                    'id'=>'addSubCatBtn',
                    'class'=>'btn btn-outline-primary',
                    'value'=>'Ajouter'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EquipmentSubCategory::class,
        ]);
    }
}
