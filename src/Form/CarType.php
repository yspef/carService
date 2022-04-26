<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Color;
use App\Entity\Model;
use App\Entity\Owner;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('patent', TextType::class)
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
        $builder->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);
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
        
        $disabled = (null == $data->getId());
        $brand = $data->getBrand();

        $form
            ->add('model', EntityType::class, 
            [
                'class'         => Model::class,
                'placeholder'   => '-- select --',
                'disabled'      => $disabled,
                'query_builder' => function(EntityRepository $er) use ($brand)
                {
                    $qb = (null != $brand) ?
                        $er->createQueryBuilder('m')
                            ->andWhere('m.brand = :brand')
                            ->setParameter(':brand', $brand) :
                        null
                    ;
    
                    return($qb);
                },                   
            ])
        ;
    }

    /**
     * onPreSubmit
     *
     * @param FormEvent $event
     * @return void
     */
    public function onPreSubmit(FormEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();
        $brand = $data['brand'];
        $disabled = empty($brand);

        $form
            ->add('model', EntityType::class, 
            [
                'class' => Model::class,
                'placeholder' => '-- select --',
                'disabled' => $disabled,
                'query_builder' => function(EntityRepository $er) use ($brand)
                {
                    $qb = $er->createQueryBuilder('m')
                            ->andWhere('m.brand = :brand')
                            ->setParameter(':brand', $brand)
                    ;
    
                    return($qb);
                },             
        ])
        ;
    }

    /**
     * configureOptions
     *
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
