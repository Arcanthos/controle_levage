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
                    'Mise en service'=>'Mise en service',
                    'Périodique'=>'Périodique',
                    'Remise en service'=>'Remise en service',
                ]
            ])
            ->add('result', CheckboxType::class,[
                'label'=>'Contrôle validé',
                'required'   => false,
            ])
            ->add('observation', TextareaType::class, [
                'label'=>'Observation',
                'required'   => false,
            ])

            //Récupération des saisies de l'utilisateur
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event)
            {
                /**@var Control $control*/
                $control = $event->getData();

                //le champ de la date du jour est rempli automatiquement lors de la validation du formulaire
                $date = new \DateTime();
                $control->setDate($date);

                //ainsi que la date du prochain contrôle dans 6 Mois
                $date1 = new\DateTime();
                $interval = new \DateInterval('P6M');
                $dateNextControl = $date1->add($interval);
                $control->setDateNextControl($dateNextControl);
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Control::class,
        ]);
    }
}
