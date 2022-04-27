<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * DescriptionTrait
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
trait DescriptionTrait
{
    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\Column(type="string", length=255)
     */ 
    private $description;

    // -------------------------------------------------------------------------
    // getters and setters

    /**
     * getDescription
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * setDescription
     *
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
