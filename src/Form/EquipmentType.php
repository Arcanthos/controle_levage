<?php

namespace App\Form;

use App\Entity\Equipment;
use App\Entity\EquipmentCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipmentCategory', EntityType::class, [
                'class'=>EquipmentCategory::class,
                'label'=>'Catégorie',
                'choice_label'=>'category',
            ])
            ->add('brand', TextType::class, [
                'label'=> 'Marque'
            ])
            ->add('model',TextType::class, [
                'label'=> 'Modèle'
            ])
            ->add('year', ChoiceType::class,[
                'label'=> 'Année de fabrication',
                'choices' => $this->getYears(1960),
            ])
            ->add('serialNumber', TextType::class, [
                'label'=> 'N° de série'
            ])
        ;
    }

    //fonction permet de créer le ChoiceType pour l'année de fabrication
    private function getYears($min, $max='current')
    {
        $years = range($min, ($max === 'current' ? date('Y') : $max));

        return array_combine($years, $years);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}
