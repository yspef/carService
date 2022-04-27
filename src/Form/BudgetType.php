<?php

namespace App\Form;

use App\Entity\Budget;
use App\Entity\BudgetItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $items = [];

        $builder
            ->add('date', DateType::class, 
            [
                'widget' => 'single_text',
            ])

            ->add('totalPrice')
            ->add('owner')
            ->add('car')

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
                        // 'add_selection' => true,
                    ],
                'allow_add'     => true,
                'allow_delete'  => true,
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
