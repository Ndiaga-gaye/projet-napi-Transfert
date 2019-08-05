<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CreationCompteRepository")
 */
class CreationCompte
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
   private $NumeroCompte;

    /**
     * @ORM\Column(type="integer")
     */
    private $Solde;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Prestataire", inversedBy="creationComptes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compteprestataire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="Comptedepot")
     */
    private $depots;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="NumeroCompte")
     */
    private $depotnumeroC;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
        $this->depotnumeroC = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSolde(): ?int
    {
        return $this->Solde;
    }

    public function setSolde(int $Solde): self
    {
        $this->Solde = $Solde;

        return $this;
    }

    public function getCompteprestataire(): ?Prestataire
    {
        return $this->compteprestataire;
    }

    public function setCompteprestataire(?Prestataire $compteprestataire): self
    {
        $this->compteprestataire = $compteprestataire;

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setComptedepot($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depots->contains($depot)) {
            $this->depots->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getComptedepot() === $this) {
                $depot->setComptedepot(null);
            }
        }

        return $this;
    }

}
