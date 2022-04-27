<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 * @ORM\Table("colors")
 */
class Color
{
    use \App\Entity\Traits\IdTrait;
    use \App\Entity\Traits\DescriptionTrait;
    use \App\Entity\Traits\OnlineTrait;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="color")
     */
    private $cars;

    // -------------------------------------------------------------------------
    // getters and setters

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
     * addCar
     *
     * @param Car $car
     * @return self
     */
    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setColor($this);
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
            if ($car->getColor() === $this) {
                $car->setColor(null);
            }
        }

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
        $zval = $this->getDescription();

        return($zval);
    }
}
