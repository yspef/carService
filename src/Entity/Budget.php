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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ORM\OneToMany(targetEntity=BudgetItem::class, mappedBy="budget", cascade={"all"})
     */
    private $items;

    // -------------------------------------------------------------------------
    // getters and setters
    
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, BudgetItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

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

    public function addItem(BudgetItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setBudget($this);
        }

        return $this;
    }

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
