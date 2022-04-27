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
    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Service::class, cascade={"persist", "remove"})
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getBudget(): ?Budget
    {
        return $this->budget;
    }

    public function setBudget(?Budget $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
