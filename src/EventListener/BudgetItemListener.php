<?php

namespace App\EventListener;

use App\Entity\BudgetItem;
use Doctrine\Persistence\Event\LifecycleEventArgs;

/**
 * BudgetItemListener
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
class BudgetItemListener
{
    /**
     * prePersist
     *
     * @param BudgetItem $budgetItem
     * @param LifecycleEventArgs $event
     * @return void
     */
    public function prePersist(BudgetItem $budgetItem, LifecycleEventArgs $event)
    {
        $this->doPrice($budgetItem);
    }

    /**
     * doPrice
     *
     * @param BudgetItem $budgetItem
     * @return void
     */
    private function doPrice(BudgetItem $budgetItem)
    {
        $service = $budgetItem->getService();
        
        $budgetItem->setPrice($service->getPrice());
    }
}
