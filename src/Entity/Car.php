<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ORM\Column(type="string", length=20)
     */
    private $patent;

    /**
     * @ORM\Column(type="integer")
     */
    private $yearModel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getPatent(): ?string
    {
        return $this->patent;
    }

    public function setPatent(string $patent): self
    {
        $this->patent = $patent;

        return $this;
    }

    public function getYearModel(): ?int
    {
        return $this->yearModel;
    }

    public function setYearModel(int $yearModel): self
    {
        $this->yearModel = $yearModel;

        return $this;
    }
}
