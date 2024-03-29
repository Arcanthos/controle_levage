<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,[
                'label'=> 'Pseudo'
            ])
            ->add('name', TextType::class,[
                'label' => 'Nom'
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Prénom'
            ])
            ->add('email', TextType::class,[
                'label'=> 'Adresse email'
            ])
            ->add('phone', TextType::class,[
                'label'=> 'Téléphone',
                'required'=>false
            ])
            //->add('password', RepeatedType::class, [
            //    'type'=> PasswordType::class,
            //    'invalid_message' => 'les deux mots de passe doivent être identique !',
            //    'required'=> true,
            //    'first_options'=> ['label'=>'Mot de passe'],
             //   'second_options'=> ['label'=>'Répéter le mot passe']
            //])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
