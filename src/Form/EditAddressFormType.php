<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditAddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Típus *',
                'choices' => [
                    'Céges' => 0,
                    'Magánszemély' => 1,
                ],
                'required' => true,
            ])
            ->add('name', null, [
                'label' => 'Név / Cégnév *',
                'required' => true,
            ])
            ->add('phonenumber', null, [
                'label' => 'Telefonszám',
                'required' => false,
            ])
            ->add('taxnumber', TextType::class, [
                'label' => 'Adószám',
                'required' => false,
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Ország *',
                'choices' => [
                    'Magyarország' => 'Magyarország',
                    'Szerbia' =>  'Szerbia',
                    'Románia' => 'Románia',
                    'Szlovákia' => 'Szlovákia',
                    'Ausztria' => 'Ausztria',
                    'Ukrajna' => 'Ukrajna',
                    'Szlovénia' => 'Szlovénia',
                    'Egyesült Királyság' => 'Egyesült Királyság',
                    'Németország' => 'Németország'
                ],
                'required' => true,
            ])
            ->add('postcode', TextType::class, [
                'label' => 'Irányítószám *',
                'required' => true,
            ])
            ->add('city', null, [
                'label' => 'Város *',
                'required' => true,
            ])
            ->add('address', null, [
                'label' => 'Utca, házszám *',
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Módosítások mentése'
            ])
            ->add('button', ButtonType::class, [
                'label' => 'Mégsem',
                'row_attr' => ['onclick' => 'window.location.href="/address"']
            ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
