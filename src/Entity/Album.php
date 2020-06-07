<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 * @ApiResource(
 *     attributes={
            "order": {"createdAt": "desc"}
 *     },
 *     normalizationContext={
            "groups"={"album_read"}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"name":"partial"})
 * @ApiFilter(OrderFilter::class, properties={"createdAt"})
 */
class Album
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"album_read"})
     * @Assert\NotBlank(message="The name is mandatory.")
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"album_read"})
     * @Assert\NotBlank(message="The created date is mandatory.")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Photo::class, inversedBy="albums")
     * @Groups({"album_read"})
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="albums")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="The user is mandatory.")
     */
    private $user;

    public function __construct()
    {
        $this->Photo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhoto(): Collection
    {
        return $this->photo;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photo->contains($photo)) {
            $this->photo[] = $photo;
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photo->contains($photo)) {
            $this->photo->removeElement($photo);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
