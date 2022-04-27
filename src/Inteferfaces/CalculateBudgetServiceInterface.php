<?php

namespace App\Inteferfaces;

/**
 * CalculateBudgetServiceInterface
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
interface CalculateBudgetServiceInterface
{
    public function calculate(array $options): float;
}
