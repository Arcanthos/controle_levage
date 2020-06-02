<?php

namespace App\Form;

use App\Entity\ClientCompany;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> 'Nom de la société'
            ])
            ->add('alias', TextType::class, [
                'label'=> 'Nom commercial'
            ])
            ->add('adress', TextType::class, [
                'label'=> 'Adresse'
            ])
            ->add('city', TextType::class, [
                'label'=> 'Ville'
            ])
            ->add('zipCode', TextType::class, [
                'label'=> 'Code Postal'
            ])
            ->add('website', TextType::class,[
                'label'=> 'Site internet'
            ])
            ->add('email', TextType::class, [
                'label'=> 'Email de contact'
            ])
            ->add('phone', TextType::class,[
                'label'=> 'Téléphone'
            ])
            ->add('fax', TextType::class,[
                'label'=> 'Fax'
            ])
            //->add('entryDate', TextType::class,)
            ->add('codeAPE_NAF', TextType::class,[
                'label'=> 'Code APE-NAF'
            ])
            ->add('numberVAT', TextType::class,[
                'label'=>'N° de TVA'
            ])
            ->add('siret', TextType::class,[
                'label'=>'N° Siret'
            ])

            //Récupération des saisies de l'utilisateur
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event)
            {
                /**@var \App\Entity\ClientCompany $clientCompany*/ //permet d'avoir l'autocomplétion sur l'entité ClientCompany
                $clientCompany = $event->getData();

                //champ rempli automatiquement lors de la validation du formulaire
                $entryDate = new \DateTime();
                $clientCompany->setEntryDate($entryDate);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClientCompany::class,
        ]);
    }
}
