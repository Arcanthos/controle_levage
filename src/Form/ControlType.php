<?php

namespace App\Form;

use App\Entity\Control;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ControlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'=>[
                    'commissioning'=>'commissioning',
                    'periodic'=>'periodic',
                    'puttingBackIntoService'=>'puttingBackIntoService',
                ],
                'choice_label' => function ($choice, $key, $value)
                {
                    if ('commissioning' === $choice) {
                        return 'Mise en service';
                    }
                    elseif ('periodic' === $choice){
                        return 'Périodique';
                    }
                    elseif ('puttingBackIntoService' === $choice)
                    {
                        return 'Remise en service';
                    }
                    return $key;
                }

                    ])

            //Récupération des saisies de l'utilisateur
           /* ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event)
            {*/
                /**@var Control $control*/
                /*$control = $event->getData();

                //le champ de la date du jour est rempli automatiquement lors de la validation du formulaire
                $date = new \DateTime();
                $control->setDate(clone $date);

                //ainsi que la date du prochain contrôle dans 6 Mois
                $interval = new \DateInterval('P6M');
                $dateNextControl = $date->add($interval);
                $control->setDateNextControl($dateNextControl);
            })*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Control::class,
        ]);
    }
}
