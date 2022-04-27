<?php

namespace App\Service;

use App\Inteferfaces\CalculateBudgetServiceInterface;
use App\Repository\ServiceRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * CalculateBudgetService
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
class CalculateBudgetService implements CalculateBudgetServiceInterface
{
    private $optionsResolver;
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->optionsResolver = new OptionsResolver();
        $this->serviceRepository = $serviceRepository;
    }

    public function calculate(array $options): float
    {
        $zval = 0;

        foreach($options['items'] as $item)
        {
            $serviceId = $item['service'];
            if(null != ($service = $this->serviceRepository->find($serviceId)))
            {
                $zval += $service->getPrice();
            }
        }

        return($zval);
    }

    private function configureOptions()
    {
        $this->optionsResolver->setDefaults(
            [
                'items' => [],
            ]);

        $this->optionsResolver->setAllowedTypes('items', 'array');
    }
}
