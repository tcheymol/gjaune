<?php

namespace App\Entity;

use App\Entity\Trait\BlameableTrait;
use App\Repository\TrackKindRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrackKindRepository::class)]
class TrackKind
{
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name;

    /**
     * @var Collection<int, Track>
     */
    #[ORM\OneToMany(targetEntity: Track::class, mappedBy: 'kind')]
    private Collection $tracks;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $fileTypes = null;

    public function __construct(?string $name = null)
    {
        $this->name = $name;
        $this->tracks = new ArrayCollection();
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

    /**
     * @return Collection<int, Track>
     */
    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    public function addTrack(Track $track): static
    {
        if (!$this->tracks->contains($track)) {
            $this->tracks->add($track);
            $track->setKind($this);
        }

        return $this;
    }

    public function removeTrack(Track $track): static
    {
        if ($this->tracks->removeElement($track)) {
            // set the owning side to null (unless already changed)
            if ($track->getKind() === $this) {
                $track->setKind(null);
            }
        }

        return $this;
    }

    public function getFileTypes(): ?array
    {
        return $this->fileTypes;
    }

    public function setFileTypes(?array $fileTypes): static
    {
        $this->fileTypes = $fileTypes;

        return $this;
    }

    public function getFileTypesAsString(): ?string
    {
        return $this->fileTypes ? implode(',', $this->fileTypes) : null;
    }
}
