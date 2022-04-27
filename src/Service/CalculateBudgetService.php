<?php

namespace App\Service;

use App\Interfaces\CalculateBudgetServiceInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * CalculateBudgetService
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
class CalculateBudgetService implements CalculateBudgetServiceInterface
{
    private $optionsResolver;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->optionsResolver = new OptionsResolver();
        $this->configureOptions();
    }

    /**
     * calculate
     *
     * @param array $options
     * @return float
     */
    public function calculate(array $options): float
    {
        $zval = 0;

        foreach($options['items'] as $item)
        {
            $zval += $item->getPrice();
        }

        return($zval);
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

        $this->optionsResolver->setAllowedTypes('items', 'App\Entity\BudgetItem[]');
    }
}
