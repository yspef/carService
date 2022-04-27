<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BudgetRepository::class)
 * @ORM\Table("budgets")
 */
class Budget
{
    use \App\Entity\Traits\IdTrait;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="budgets")
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Car::class, inversedBy="budgets")
     */
    private $car;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=2)
     */
    private $totalPrice;

    /**
     * @ORM\OneToMany(targetEntity=BudgetItem::class, mappedBy="budget", cascade={"persist", "remove"})
     */
    private $items;

    // -------------------------------------------------------------------------
    // getters and setters
    
    /**
     * @return Collection<int, BudgetItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * getDate
     *
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * setDate
     *
     * @param \DateTimeInterface $date
     * @return self
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * getOwner
     *
     * @return Owner|null
     */
    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    /**
     * setOwner
     *
     * @param Owner|null $owner
     * @return self
     */
    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * getCar
     *
     * @return Car|null
     */
    public function getCar(): ?Car
    {
        return $this->car;
    }

    /**
     * setCar
     *
     * @param Car|null $car
     * @return self
     */
    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    /**
     * getTotalPrice
     *
     * @return string|null
     */
    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    /**
     * setTotalPrice
     *
     * @param string $totalPrice
     * @return self
     */
    public function setTotalPrice(string $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    // -------------------------------------------------------------------------
    // helper methods
    
    /**
     * magic method __toString
     *
     * @return string
     */
    public function __toString(): string
    {
        $zval = $this->getOwner() . ' ' . $this->getCar() . ' ' . $this->getDate()->format('d/m/Y');

        return($zval);
    }

    // -------------------------------------------------------------------------
    // adders and removers

    /**
     * addItem
     *
     * @param BudgetItem $item
     * @return self
     */
    public function addItem(BudgetItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setBudget($this);
        }

        return $this;
    }

    /**
     * removeItem
     *
     * @param BudgetItem $item
     * @return self
     */
    public function removeItem(BudgetItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getBudget() === $this) {
                $item->setBudget(null);
            }
        }

        return $this;
    }
}
