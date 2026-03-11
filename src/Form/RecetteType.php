<?php

namespace App\Form;

use App\Entity\Recette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
            ])
            ->add('ttc55', MoneyType::class, [
                'label' => 'Recettes TTC à 5,5%',
                'currency' => 'EUR',
                'required' => false,
            ])
            ->add('ttc10', MoneyType::class, [
                'label' => 'Recettes TTC à 10%',
                'currency' => 'EUR',
                'required' => false,
            ])
            ->add('ttc20', MoneyType::class, [
                'label' => 'Recettes TTC à 20%',
                'currency' => 'EUR',
                'required' => false,
            ])
            ->add('pourboire', MoneyType::class, [
                'label' => 'Pourboires',
                'currency' => 'EUR',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}