<?php

namespace App\Filter;

use App\Entity\Owner;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetFilterType extends AbstractType
{
    /**
     * buildForm
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('patent', Filters\TextFilterType::class)

            // ->add('firstname', Filters\TextFilterType::class,
            // [
                // 'apply_filter' => [ $this, 'ownerFilter'],
            // ])

            // ->add('lastname', Filters\TextFilterType::class,
            // [
            //     'apply_filter' => [ $this, 'ownerFilter'],
            // ])
        ;
    }

    // public function ownerFilter(QueryInterface $filterQuery, $field, $values)
    // {
    //     if( empty( $values['value'] ) ) 
    //     {
    //         return null;
    //     }

    //     // $qb = $filterQuery->getQueryBuilder();
    //     // $qb
    //     //     ->leftJoin(Owner::class, 'owner',  'WITH', 'owner.id = ' . $values['alias'] . '.owner' )
    //     //     // ->leftJoin( $this->equipmentClass, 'e',  'WITH', 'e.id = ' . 'r.equipment' )
    //     // ;

    //     $paramName = sprintf('p_%s', str_replace('.', '_', $field));

    //     $parameters = "'%" . $values['value'] . "%'";

    //     $filterField = 'owner' . substr($field, strlen($values['alias']));

    //     $expression = $filterQuery->getExpr()->like($filterField, $parameters);

    //     $parameters = [ $paramName => $values['value'] ];

    //     $zval =  $filterQuery->createCondition($expression);

    //     return($zval);
    // }
    
    /**
     * configureOptions
     *
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
        [
            'csrf_protection'   => false,
            'validation_groups' => ['filtering'], // avoid NotBlank() constraint-related message
        ]);
    }

    /**
     * getBlockPrefix
     *
     * @return string
     */
    public function getBlockPrefix(): string
    {
        $zval = 'budget_filter_type';

        return($zval);
    }
}