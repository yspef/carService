<?php

namespace App\Resolver;

use App\Interfaces\BudgetItemsResolverInterface;
use App\Repository\ServiceRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * BudgetItemsResolver
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
class BudgetItemsResolver implements BudgetItemsResolverInterface
{
    private $optionsResolver;
    private $serviceRepository;

    /**
     * constructor
     *
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->optionsResolver = new OptionsResolver();
        $this->configureOptions();

        $this->serviceRepository = $serviceRepository;
    }

    /**
     * configureOptions
     *
     * @return void
     */
    private function configureOptions()
    {
        $this->optionsResolver->setDefaults(
            [
                'items' => [],
            ]);

        $this->optionsResolver->setAllowedTypes('items', 'int[]');
    }

    /**
     * resolve
     *
     * @param array $options
     * @return array
     */
    public function resolve(array $options): array
    {
        $zval = [];

        foreach($options['items'] as $item)
        {
            $serviceId = $item['service'];

            if(null != ($service = $this->serviceRepository->find($serviceId)))
            {
                $zval[] = $service;
            }
        }

        return($zval);
    }
}
