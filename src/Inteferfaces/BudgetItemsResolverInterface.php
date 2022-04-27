<?php

namespace App\Inteferfaces;

/**
 * BudgetItemsResolverInterface
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
interface BudgetItemsResolverInterface
{
    public function resolve(array $options): array;
}
