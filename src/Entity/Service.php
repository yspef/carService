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
    use \App\Entity\Traits\IdTrait;
    use \App\Entity\Traits\DescriptionTrait;
    use \App\Entity\Traits\OnlineTrait;

    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\Column(type="decimal", precision=16, scale=2)
     * @Assert\GreaterThan(value=0)
     */
    private $price;

    // -------------------------------------------------------------------------
    // getters and setters

    /**
     * getPrice
     *
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * setPrice
     *
     * @param string $price
     * @return self
     */
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
        $zval = $this->getDescription() . ' - $ ' . $this->getPrice();

        return($zval);
    }
}
