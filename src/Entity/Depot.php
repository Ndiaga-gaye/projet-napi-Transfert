<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $MontantDepot;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     */
    private $Comptedepot;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumeroCompte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CreationCompte", inversedBy="depotcompte")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creationcompte;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantDepot(): ?int
    {
        return $this->MontantDepot;
    }

    public function setMontantDepot(int $MontantDepot): self
    {
        $this->MontantDepot = $MontantDepot;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getComptedepot(): ?CreationCompte
    {
        return $this->Comptedepot;
    }

    public function setComptedepot(?CreationCompte $Comptedepot): self
    {
        $this->Comptedepot = $Comptedepot;

        return $this;
    }

    public function getNumeroCompte(): ?int
    {
        return $this->NumeroCompte;
    }

    public function setNumeroCompte(int $NumeroCompte): self
    {
        $this->NumeroCompte = $NumeroCompte;

        return $this;
    }

    public function getCreationcompte(): ?CreationCompte
    {
        return $this->creationcompte;
    }

    public function setCreationcompte(?CreationCompte $creationcompte): self
    {
        $this->creationcompte = $creationcompte;

        return $this;
    }


}
