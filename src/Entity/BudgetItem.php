<?php

namespace App\Entity;

use App\Repository\BudgetItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BudgetItemRepository::class)
 * @ORM\Table("budgets_items")
 */
class BudgetItem
{
    use \App\Entity\Traits\IdTrait;

    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity=Budget::class, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $budget;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=2)
     */
    private $price;

    // -------------------------------------------------------------------------
    // getters and setters

    /**
     * getService
     *
     * @return Service|null
     */
    public function getService(): ?Service
    {
        return $this->service;
    }

    /**
     * setService
     *
     * @param Service $service
     * @return self
     */
    public function setService(Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * getBudget
     *
     * @return Budget|null
     */
    public function getBudget(): ?Budget
    {
        return $this->budget;
    }

    /**
     * setBudget
     *
     * @param Budget|null $budget
     * @return self
     */
    public function setBudget(?Budget $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * getPrice
     *
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * setPrice
     *
     * @param string $price
     * @return self
     */
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
