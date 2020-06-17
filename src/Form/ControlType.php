<?php

namespace App\Form;

use App\Entity\Control;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ControlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'=>[
                    'Mise en service'=>'CommissioningControl',
                    'Périodique'=>'PeriodicControl',
                    'Remise en service'=>'ReturnToServiceControl',
                ],
                'choice_label'=> function ($choice, $key, $value){
                    if('CommissioningControl' === $choice)
                    {
                        return 'Mise en service';
                    }
                    elseif ('PeriodicControl' === $choice)
                    {
                        return 'Périodique';
                    }
                    elseif ('ReturnToServiceControl' === $choice)
                    {
                        return 'Remise en service';
                    }
                    return $key;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Control::class,
        ]);
    }
}
