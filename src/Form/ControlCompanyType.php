<?php

namespace App\Form;

use App\Entity\ControlCompany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ControlCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Nom de société'
            ])
            ->add('alias', TextType::class, [
            'label'=>'Nom commercial'])
            ->add('adress', TextType::class,[
                'label'=>'Adresse'
            ])
            ->add('city', TextType::class,[
                'label'=>'Ville'
            ])
            ->add('zipCode', TextType::class,[
                'label'=>'Code Postal'
            ])
            ->add('website', TextType::class,[
                'label'=>'Site internet'
            ])
            ->add('mail', TextType::class,[
                'label'=>'Email de contact'
            ])
            ->add('phone', TextType::class,[
                'label'=>'Téléphone'
            ])
            ->add('fax', TextType::class,[
                'label'=>'Fax'
            ])
            ->add('codeAPE_NAF', TextType::class,[
                'label'=>'Code APE-NAF'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ControlCompany::class,
        ]);
    }
}
