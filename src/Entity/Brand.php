<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 * @ORM\Table("brands")
 */
class Brand
{
    use \App\Entity\Traits\IdTrait;
    use \App\Entity\Traits\DescriptionTrait;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->models = new ArrayCollection();
        $this->cars = new ArrayCollection();
    }

    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\OneToMany(targetEntity=Model::class, mappedBy="brand")
     */ 
    private $models;

    /**
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="brand")
     */ 
    private $cars;

    // -------------------------------------------------------------------------
    // getters and setters

    /**
     * @return Collection<int, Model>
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    /**
     * addModel
     *
     * @param Model $model
     * @return self
     */
    public function addModel(Model $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models[] = $model;
            $model->setBrand($this);
        }

        return $this;
    }

    // -------------------------------------------------------------------------
    // adders and removers

    /**
     * removeModel
     *
     * @param Model $model
     * @return self
     */
    public function removeModel(Model $model): self
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
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
            $car->setBrand($this);
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
            if ($car->getBrand() === $this) {
                $car->setBrand(null);
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
