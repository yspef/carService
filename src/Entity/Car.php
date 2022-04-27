<?php

namespace App\Entity;

use App\Repository\CarRepository;
use App\Validator as AppAsserts;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 * @ORM\Table("cars",
 *      uniqueConstraints={@ORM\UniqueConstraint(name="patent", columns={"patent"})},
 *      indexes={@ORM\Index(name="idx_patent", columns={"patent"}),
 *  }
 * )
 * @UniqueEntity(fields={"patent"})
  */
class Car
{
    use \App\Entity\Traits\IdTrait;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->budgets = new ArrayCollection();
    }

    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="cars")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class, inversedBy="cars")
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="cars")
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $patent;

    /**
     * @ORM\Column(type="integer")
     * @AppAsserts\CarYear()
     */
    private $yearModel;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class, inversedBy="cars")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=Budget::class, mappedBy="car")
     */
    private $budgets;

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
     * getColor
     *
     * @return Color|null
     */
    public function getColor(): ?Color
    {
        return $this->color;
    }

    /**
     * setColor
     *
     * @param Color|null $color
     * @return self
     */
    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * getModel
     *
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * setModel
     *
     * @param Model|null $model
     * @return self
     */
    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * getPatent
     *
     * @return string|null
     */
    public function getPatent(): ?string
    {
        return $this->patent;
    }

    /**
     * setPatent
     *
     * @param string $patent
     * @return self
     */
    public function setPatent(string $patent): self
    {
        $this->patent = $patent;

        return $this;
    }

    /**
     * getYearModel
     *
     * @return integer|null
     */
    public function getYearModel(): ?int
    {
        return $this->yearModel;
    }

    /**
     * setYearModel
     *
     * @param integer $yearModel
     * @return self
     */
    public function setYearModel(int $yearModel): self
    {
        $this->yearModel = $yearModel;

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
     * @return Collection<int, Budget>
     */
    public function getBudgets(): Collection
    {
        return $this->budgets;
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
            $budget->setCar($this);
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
            if ($budget->getCar() === $this) {
                $budget->setCar(null);
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
        $zval = $this->getBrand() . ' ' . $this->getModel() . ' ' . $this->getOwner() . ' ' . $this->getPatent();

        return($zval);
    }
}
