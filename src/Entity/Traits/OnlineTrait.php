<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * OnlineTrait
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
trait OnlineTrait
{
    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\Column(type="boolean")
     */ 
    private $online = true;

    // -------------------------------------------------------------------------
    // getters and setters

    /**
     * getOnline
     *
     * @return boolean|null
     */
    public function getOnline(): ?bool
    {
        return $this->online;
    }

    /**
     * setOnline
     *
     * @param boolean $online
     * @return self
     */
    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }
}
