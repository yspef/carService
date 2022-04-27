<?php

namespace App\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * HistoricalFilterType
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
class HistoricalFilterType extends AbstractType
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
            ->add('patent', Filters\TextFilterType::class)
        ;
    }
   
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
        $zval = 'historical_filter_type';

        return($zval);
    }
}