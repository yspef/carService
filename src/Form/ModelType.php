<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Model;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('online')

            ->add('brand', EntityType::class, 
            [
                'class' => Brand::class,
                'placeholder' => '-- select --',
                'query_builder' => function(EntityRepository $er)
                {
                    $qb = $er->choices();

                    return($qb);
                },                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Model::class,
        ]);
    }
}
