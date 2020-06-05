<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> 'Nom'
            ])
            ->add('firstname', TextType::class, [
                'label'=> 'Prénom'
            ])
            ->add('phone', TextType::class,[
                'label'=> 'Téléphone'
            ])
            ->add('phoneBis', TextType::class, [
                'label' => 'Téléphone 2',
                'required'   => false,
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Dirigeant' => 'Dirigeant',
                    'Secrétaire' => 'Secrétaire',
                    'Commercial' => 'Commercial',
                    'Employé' => 'Employé',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
