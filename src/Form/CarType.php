<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Color;
use App\Entity\Model;
use App\Entity\Owner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('patent')
            ->add('yearModel')

            ->add('brand', EntityType::class, 
            [
                'class' => Brand::class,
                'placeholder' => '-- select --',
            ])

            ->add('color', EntityType::class, 
            [
                'class' => Color::class,
                'placeholder' => '-- select --',
            ])

            ->add('owner', EntityType::class, 
            [
                'class' => Owner::class,
                'placeholder' => '-- select --',
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
    }

    /**
     * onPreSetData
     *
     * @param FormEvent $event
     * @return void
     */
    public function onPreSetData(FormEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();

        $disbled = (null == $data->getId());

        $form
            ->add('model', EntityType::class, 
            [
                'class' => Model::class,
                'placeholder' => '-- select --',
                'disabled' => $disbled,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
