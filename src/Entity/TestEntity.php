<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestEntityRepository")
 */
class TestEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $eqSiteLimit;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $huSiteLimit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEqSiteLimit(): ?float
    {
        return $this->eqSiteLimit;
    }

    public function setEqSiteLimit(?float $eqSiteLimit): self
    {
        $this->eqSiteLimit = $eqSiteLimit;

        return $this;
    }

    public function getHuSiteLimit(): ?float
    {
        return $this->huSiteLimit;
    }

    public function setHuSiteLimit(?float $huSiteLimit): self
    {
        $this->huSiteLimit = $huSiteLimit;

        return $this;
    }
}
