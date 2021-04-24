<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @Vich\Uploadable
 */
class Project
{
    public const TYPES = ['perso', 'pro'];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le titre ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $photo;

    /**
     * @Vich\UploadableField(mapping="project_file", fileNameProperty="photo")
     * @var File
     * @Assert\File(
     *      maxSize = "300k",
     *      maxSizeMessage = "Le fichier est trop lourd ({{ size }}{{ suffix }}), {{ limit }}{{ suffix }} maximum",
     *      mimeTypes = {"image/png", "image/jpg", "image/jpeg", "image/gif"},
     *      mimeTypesMessage = "Le format {{ type }} n'est pas autorisé, formats autorisés: {{ types }}",
     * )
     */
    private $photoFile;

    /**
     * @ORM\Column(type="string", length=1000)
     * @var string
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 1000,
     *      minMessage = "Le texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le lien est trop long, il dépasse {{ limit }} caractères"
     * )
     */
    private $linkWeb;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le lien est trop long, il dépasse {{ limit }} caractères"
     * )
     */
    private $linkGit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le lien est trop long, il dépasse {{ limit }} caractères"
     * )
     */
    private $linkVideo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le lien est trop long, il dépasse {{ limit }} caractères"
     * )
     */
    private $linkInfos;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     * @Assert\Choice(
     *      choices=Project::TYPES,
     *      message = "Type invalide"
     * )
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Techno::class, mappedBy="project")
     */
    private $technos;

    /**
     * @ORM\Column(type="datetime")
     * @var \Datetime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     */
    private $position;

    public function __construct()
    {
        $this->technos = new ArrayCollection();
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function setPhotoFile(File $image = null): void
    {
        $this->photoFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getLinkWeb(): ?string
    {
        return $this->linkWeb;
    }

    public function setLinkWeb(?string $linkWeb): self
    {
        $this->linkWeb = $linkWeb;

        return $this;
    }

    public function getLinkGit(): ?string
    {
        return $this->linkGit;
    }

    public function setLinkGit(?string $linkGit): self
    {
        $this->linkGit = $linkGit;

        return $this;
    }

    public function getLinkVideo(): ?string
    {
        return $this->linkVideo;
    }

    public function setLinkVideo(?string $linkVideo): self
    {
        $this->linkVideo = $linkVideo;

        return $this;
    }

    public function getLinkInfos(): ?string
    {
        return $this->linkInfos;
    }

    public function setLinkInfos(?string $linkInfos): self
    {
        $this->linkInfos = $linkInfos;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Techno[]
     */
    public function getTechnos(): Collection
    {
        return $this->technos;
    }

    public function addTechno(Techno $techno): self
    {
        if (!$this->technos->contains($techno)) {
            $this->technos[] = $techno;
            $techno->addProject($this);
        }

        return $this;
    }

    public function removeTechno(Techno $techno): self
    {
        if ($this->technos->removeElement($techno)) {
            $techno->removeProject($this);
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
