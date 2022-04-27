<?php

namespace App\Entity;

use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModelRepository::class)
 * @ORM\Table("models")
 */
class Model
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
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="models")
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="model")
     */
    private $cars;

    // -------------------------------------------------------------------------
    // getters and setters

    /**
     * getBrand
     *
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * setBrand
     *
     * @param Brand|null $brand
     * @return self
     */
    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

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
     * addCar
     *
     * @param Car $car
     * @return self
     */
    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setModel($this);
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
            if ($car->getModel() === $this) {
                $car->setModel(null);
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
