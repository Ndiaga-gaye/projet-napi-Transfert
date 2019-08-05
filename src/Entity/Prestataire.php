<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PrestataireRepository")
 */
class Prestataire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $RaisonSocial;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Ninea;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adresse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="prestataire")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CreationCompte", mappedBy="compteprestataire")
     */
    private $creationComptes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->creationComptes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->RaisonSocial;
    }

    public function setRaisonSocial(string $RaisonSocial): self
    {
        $this->RaisonSocial = $RaisonSocial;

        return $this;
    }

    public function getNinea(): ?string
    {
        return $this->Ninea;
    }

    public function setNinea(string $Ninea): self
    {
        $this->Ninea = $Ninea;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setPrestataire($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getPrestataire() === $this) {
                $user->setPrestataire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CreationCompte[]
     */
    public function getCreationComptes(): Collection
    {
        return $this->creationComptes;
    }

    public function addCreationCompte(CreationCompte $creationCompte): self
    {
        if (!$this->creationComptes->contains($creationCompte)) {
            $this->creationComptes[] = $creationCompte;
            $creationCompte->setCompteprestataire($this);
        }

        return $this;
    }

    public function removeCreationCompte(CreationCompte $creationCompte): self
    {
        if ($this->creationComptes->contains($creationCompte)) {
            $this->creationComptes->removeElement($creationCompte);
            // set the owning side to null (unless already changed)
            if ($creationCompte->getCompteprestataire() === $this) {
                $creationCompte->setCompteprestataire(null);
            }
        }

        return $this;
    }
}
