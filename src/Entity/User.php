<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 15)]
    private $username;

    #[ORM\Column(type: 'string', length: 50)]
    private $Name;

    #[ORM\Column(type: 'string', length: 50)]
    private $FirstName;

    #[ORM\Column(type: 'string', length: 10)]
    private $password;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Voiture::class)]
    private $voitureId;

    public function __construct()
    {
        $this->voitureId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Voiture>
     */
    public function getVoitureId(): Collection
    {
        return $this->voitureId;
    }

    public function addVoitureId(Voiture $voitureId): self
    {
        if (!$this->voitureId->contains($voitureId)) {
            $this->voitureId[] = $voitureId;
            $voitureId->setUser($this);
        }

        return $this;
    }

    public function removeVoitureId(Voiture $voitureId): self
    {
        if ($this->voitureId->removeElement($voitureId)) {
            // set the owning side to null (unless already changed)
            if ($voitureId->getUser() === $this) {
                $voitureId->setUser(null);
            }
        }

        return $this;
    }
}
