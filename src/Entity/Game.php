<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $launchAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $noteGlobal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pathImg;

    /**
     * @ORM\OneToOne(targetEntity=Forum::class, inversedBy="game", cascade={"persist", "remove"})
     */
    private $forums;

    /**
     * @ORM\ManyToMany(targetEntity=GameCategory::class, inversedBy="games")
     */
    private $gameCategories;

    /**
     * @ORM\ManyToMany(targetEntity=Device::class, inversedBy="games")
     */
    private $devices;

    public function __construct()
    {
        $this->gameCategories = new ArrayCollection();
        $this->devices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLaunchAt(): ?\DateTimeInterface
    {
        return $this->launchAt;
    }

    public function setLaunchAt(?\DateTimeInterface $launchAt): self
    {
        $this->launchAt = $launchAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNoteGlobal(): ?int
    {
        return $this->noteGlobal;
    }

    public function setNoteGlobal(?int $noteGlobal): self
    {
        $this->noteGlobal = $noteGlobal;

        return $this;
    }

    public function getPathImg(): ?string
    {
        return $this->pathImg;
    }

    public function setPathImg(?string $pathImg): self
    {
        $this->pathImg = $pathImg;

        return $this;
    }

    public function getForums(): ?Forum
    {
        return $this->forums;
    }

    public function setForums(?Forum $forums): self
    {
        $this->forums = $forums;

        return $this;
    }

    /**
     * @return Collection|GameCategory[]
     */
    public function getGameCategories(): Collection
    {
        return $this->gameCategories;
    }

    public function addGameCategory(GameCategory $gameCategory): self
    {
        if (!$this->gameCategories->contains($gameCategory)) {
            $this->gameCategories[] = $gameCategory;
        }

        return $this;
    }

    public function removeGameCategory(GameCategory $gameCategory): self
    {
        $this->gameCategories->removeElement($gameCategory);

        return $this;
    }

    /**
     * @return Collection|Device[]
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        $this->devices->removeElement($device);

        return $this;
    }
}
