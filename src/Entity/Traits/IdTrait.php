<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * IdTrait
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
trait IdTrait
{
    // -------------------------------------------------------------------------
    // properties

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */ 
    private $id;

    // -------------------------------------------------------------------------
    // getters and setters

    /**
     * getId
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
