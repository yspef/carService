<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 * @ORM\Table("services")
 */
class Service
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $online = true;

    /**
     * @ORM\Column(type="decimal", precision=16, scale=2)
     * @Assert\GreaterThan(value=0)
     */
    private $price;

    // -------------------------------------------------------------------------
    // getters and setters
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

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
