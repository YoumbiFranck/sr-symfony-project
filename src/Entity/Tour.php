<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\TourRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TourRepository::class)]
class Tour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTime $startdate = null;

    #[ORM\Column]
    private ?\DateTime $enddate = null;

    #[ORM\ManyToOne(targetEntity: TravelCompanion::class, inversedBy: 'tours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TravelCompanion $travelCompanion = null;

    #[ORM\ManyToMany(targetEntity: Tags::class, inversedBy: 'tours')]
    #[ORM\JoinTable(name: 'tour_tags')]
    private Collection $tags;


    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * @return Collection<int, Tags>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }
        return $this;
    }

    public function removeTag(Tags $tag): static
    {
        $this->tags->removeElement($tag);
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

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

    public function getStartdate(): ?\DateTime
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTime $startdate): static
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEnddate(): ?\DateTime
    {
        return $this->enddate;
    }

    public function setEnddate(\DateTime $enddate): static
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getTravelCompanion(): ?TravelCompanion
    {
        return $this->travelCompanion;
    }

    public function setTravelCompanion(?TravelCompanion $travelCompanion): static
    {
        $this->travelCompanion = $travelCompanion;
        return $this;
    }
}
