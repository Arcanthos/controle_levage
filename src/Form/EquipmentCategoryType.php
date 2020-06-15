<?php

namespace App\Form;

use App\Entity\EquipmentCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', TextType::class,[
                'label'=>'Nom de la catégorie'])
            ->add('accessories', ChoiceType::class,[
                'choices'=>[
                    'oui'=>true,
                    'non'=>false
                ],
                'label'=>'Cette Catégorie a-t-elle des accessoires ?',
                'multiple' => false,
                'expanded' => true
            ])
            ->add('hasCommissioningControl',ChoiceType::class,[
                'choices'=>[
                    'oui'=>true,
                    'non'=>false
                ],
                'label'=>'Cette Catégorie a-t-elle un controle de mise en service ?',
                'multiple' => false,
                'expanded' => true
            ])
            ->add('hasPeriodicControl',ChoiceType::class,[
                'choices'=>[
                    'oui'=>true,
                    'non'=>false
                ],
                'label'=>'Cette Catégorie a-t-elle des controles périodique ?',
                'multiple' => false,
                'expanded' => true
            ])
            ->add('hasReturnToServiceControl',ChoiceType::class,[
                'choices'=>[
                    'oui'=>true,
                    'non'=>false
                ],
                'label'=>'Cette Catégorie a-t-elle un controle de remise en service ?',
                'multiple' => false,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EquipmentCategory::class,
        ]);
    }
}
