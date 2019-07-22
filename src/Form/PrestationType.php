<?php

namespace App\Form;

use App\Entity\Prestation;

use function Sodium\add;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client')
            ->add('massage')
            ->add('prestationDate',DateType::class,[
                'widget'=>'single_text',
                'label'=>'Date'
            ])
            ->add('startTime',TimeType::class,[
                'widget'=>'single_text',
                'label'=>'De'
            ] )
            ->add('endTime',TimeType::class,[
                'widget'=>'single_text',
                'label'=>'À'
            ] );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Prestation::class,
        ]);
    }
}
