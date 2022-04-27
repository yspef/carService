<?php

namespace App\Entity;

use App\Repository\OwnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OwnerRepository::class)
 * @ORM\Table("owners")
 */
class Owner
{
    use \App\Entity\Traits\IdTrait;

    /**
     * constructor
     */    
    public function __construct()
    {
        $this->cars = new ArrayCollection();
        $this->budgets = new ArrayCollection();
    }

    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="owner")
     */
    private $cars;

    /**
     * @ORM\OneToMany(targetEntity=Budget::class, mappedBy="owner")
     */
    private $budgets;

    // -------------------------------------------------------------------------
    // getters and setters

    /**
     * @return Collection<int, Budget>
     */
    public function getBudgets(): Collection
    {
        return $this->budgets;
    }

    /**
     * getFirstname
     *
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * setFirstname
     *
     * @param string $firstname
     * @return self
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * getLastname
     *
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * setLastname
     *
     * @param string $lastname
     * @return self
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    // -------------------------------------------------------------------------
    // adders and removers

    /**
     * addBudget
     *
     * @param Budget $budget
     * @return self
     */
    public function addBudget(Budget $budget): self
    {
        if (!$this->budgets->contains($budget)) {
            $this->budgets[] = $budget;
            $budget->setOwner($this);
        }

        return $this;
    }

    /**
     * removeBudget
     *
     * @param Budget $budget
     * @return self
     */
    public function removeBudget(Budget $budget): self
    {
        if ($this->budgets->removeElement($budget)) {
            // set the owning side to null (unless already changed)
            if ($budget->getOwner() === $this) {
                $budget->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * addCar
     *
     * @param Car $car
     * @return self
     */
    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setOwner($this);
        }

        return $this;
    }

    /**
     * removeCar
     *
     * @param Car $car
     * @return self
     */
    public function removeCar(Car $car): self
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getOwner() === $this) {
                $car->setOwner(null);
            }
        }

        return $this;
    }

    // -------------------------------------------------------------------------
    // helper methods

    /**
     * fullname
     *
     * @return string
     */
    public function fullname(): string
    {
        $zval = $this->getFirstname() . ' ' . $this->getLastname();

        return($zval);
    }

    /**
     * magic method __toString
     *
     * @return string
     */
    public function __toString(): string
    {
        $zval = $this->fullname();

        return($zval);
    }
}
