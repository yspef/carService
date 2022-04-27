<?php

namespace App\EventListener;

use App\Entity\Budget;
use App\Inteferfaces\CalculateBudgetServiceInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * BudgetListener
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
class BudgetListener
{
    private $calculateBudgetService;

    /**
     * constructor
     *
     * @param CalculateBudgetServiceInterface $calculateBudgetService
     */
    public function __construct(CalculateBudgetServiceInterface $calculateBudgetService)
    {
        $this->calculateBudgetService = $calculateBudgetService;
    }

    /**
     * prePersist
     *
     * @param Event $event
     * @return void
     */
    public function prePersist(Budget $budget, LifecycleEventArgs $event)
    {
        $this->doPrice($budget);
    }

    /**
     * preUpdate
     *
     * @param Budget $budget
     * @param LifecycleEventArgs $event
     * @return void
     */
    public function preUpdate(Budget $budget, LifecycleEventArgs $event)
    {
        $this->doPrice($budget);
    }

    /**
     * doPrice
     *
     * @param Budget $budget
     * @return void
     */
    private function doPrice(Budget $budget)
    {
        foreach($budget->getItems() as $item)
        {
            $item->setPrice($item->getService()->getPrice());
        }
        
        $budget->setTotalPrice($this->calculateBudgetService->calculate(['items' => $budget->getItems()]));
    }
}
