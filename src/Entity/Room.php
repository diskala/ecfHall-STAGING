<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
#[ORM\Index(name: 'Room', columns: ['name', 'address'], flags: ['fulltext'])]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column]
    private ?float $dayPrice = null;

    #[ORM\Column]
    private ?bool $isRentable = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: Booking::class)]
    private Collection $bookings;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\ManyToMany(targetEntity: Optional::class, mappedBy: 'rooms')]
    private Collection $optionals;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->optionals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id= $id;

        return $this;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getDayPrice(): ?float
    {
        return $this->dayPrice;
    }

    public function setDayPrice(float $dayPrice): static
    {
        $this->dayPrice = $dayPrice;

        return $this;
    }

    public function isIsRentable(): ?bool
    {
        return $this->isRentable;
    }

    public function setIsRentable(bool $isRentable): static
    {
        $this->isRentable = $isRentable;

        return $this;
    }


    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): static
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setRoom($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): static
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getRoom() === $this) {
                $booking->setRoom(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() ?? '';
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
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
            $optional->addRoom($this);
        }

        return $this;
    }

    public function removeOptional(Optional $optional): static
    {
        if ($this->optionals->removeElement($optional)) {
            $optional->removeRoom($this);
        }

        return $this;
    }
}
