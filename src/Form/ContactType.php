<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
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
                'label' => 'Téléphone 2'
            ])
            ->add('status', TextType::class, [
                'label'=>'Statut', 'choice_label'=>'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
