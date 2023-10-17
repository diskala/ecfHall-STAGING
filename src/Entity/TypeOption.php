<?php

namespace App\Entity;

use App\Repository\TypeOptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeOptionRepository::class)]
class TypeOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Optional::class)]
    private Collection $optionals;

    public function __construct()
    {
        $this->optionals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


    public function __toString(): string
    {
        return $this->name ?? '';
    }

    /**
     * @return Collection<int, Optional>
     */
    public function getOptionals(): Collection
    {
        return $this->optionals;
    }

    public function addOptional(Optional $optional): static
    {
        if (!$this->optionals->contains($optional)) {
            $this->optionals->add($optional);
            $optional->setType($this);
        }

        return $this;
    }

    public function removeOptional(Optional $optional): static
    {
        if ($this->optionals->removeElement($optional)) {
            // set the owning side to null (unless already changed)
            if ($optional->getType() === $this) {
                $optional->setType(null);
            }
        }

        return $this;
    }
}
