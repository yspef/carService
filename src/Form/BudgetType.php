<?php

namespace App\Form;

use App\Entity\Budget;
use App\Entity\BudgetItem;
use App\Entity\Car;
use App\Entity\Owner;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $data = $builder->getData();
        $date = (null == $data->getId()) ? (new DateTime()) : $data->getDate();
        $items = [];

        $builder
            ->add('date', DateType::class, 
            [
                'widget' => 'single_text',
                'data' => $date,
            ])

            ->add('totalPrice')

            ->add('owner', EntityType::class, 
            [
                'placeholder'   => '-- select --',
                'class' => Owner::class,
            ])

            ->add('car', EntityType::class, 
            [
                'placeholder'   => '-- select --',
                'class' => Car::class,
            ])

            ->add('items', CollectionType::class, 
            [
                'entry_type'    => BudgetItemType::class,
                'data'          => $items,
                'mapped'        => true,
                'label'         => false,
                'entry_options' => 
                    [ 
                        'data_class' => BudgetItem::class, 
                        'label' => false,
                    ],
                'allow_add'     => true,
                'allow_delete'  => true,
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
        $owner = $data->getOwner();

        $form
            ->add('car', EntityType::class, 
            [
                'class'         => Car::class,
                'placeholder'   => '-- select --',
                'disabled'      => $disabled,
                'query_builder' => function(EntityRepository $er) use ($owner)
                {
                    $qb = (null != $owner) ?
                        $er->createQueryBuilder('c')
                            ->andWhere('c.owner = :owner')
                            ->setParameter(':owner', $owner) :
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
        $resolver->setDefaults(
        [
            'data_class' => Budget::class,
        ]);
    }
}
