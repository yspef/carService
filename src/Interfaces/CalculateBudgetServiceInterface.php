<?php

namespace App\Interfaces;

/**
 * CalculateBudgetServiceInterface
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
interface CalculateBudgetServiceInterface
{
    public function calculate(array $options): float;
}
