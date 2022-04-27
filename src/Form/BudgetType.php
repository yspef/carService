<?php

namespace App\Form;

use App\Entity\Budget;
use App\Entity\BudgetItem;
use App\Entity\Car;
use App\Entity\Owner;
use App\Validator\Service;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * BudgetType
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $data  = $builder->getData();
        $date  = (null == $data->getId()) ? (new DateTime()) : $data->getDate();
        $items = (null == $data->getId()) ? [] : $data->getItems();

        $builder
            ->add('date', DateType::class, 
            [
                'widget' => 'single_text',
                'data' => $date,
            ])

            ->add('totalPrice', MoneyType::class,
            [ 
                'attr' => 
                    [
                        'readonly' => 'readonly',
                    ],

                'currency' => 'ARS',
            ])

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
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
                'data'          => $items,
                'entry_type'    => BudgetItemType::class,
                'entry_options' => 
                    [ 
                        'data_class' => BudgetItem::class, 
                        'label' => false,
                    ],
                'label'         => false,
                'mapped'        => true,
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
        $owner = $data['owner'];
        $disabled = empty($owner);

        $form
            ->add('car', EntityType::class, 
            [
                'class' => Car::class,
                'placeholder' => '-- select --',
                'disabled' => $disabled,
                'query_builder' => function(EntityRepository $er) use ($owner)
                {
                    $qb = $er->createQueryBuilder('m')
                            ->andWhere('m.owner = :owner')
                            ->setParameter(':owner', $owner)
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
            'data_class'    => Budget::class,
            'constraints'   => [ new Service(), ],
        ]);
    }
}
