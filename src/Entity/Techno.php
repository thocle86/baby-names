<?php

namespace App\Entity;

use App\Repository\TechnoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=TechnoRepository::class)
 * @Vich\Uploadable
 */
class Techno
{
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
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $logo;

    /**
     * @Vich\UploadableField(mapping="techno_file", fileNameProperty="logo")
     * @var File
     * @Assert\File(
     *      maxSize = "50k",
     *      maxSizeMessage = "Le fichier est trop lourd ({{ size }}{{ suffix }}), {{ limit }}{{ suffix }} maximum",
     *      mimeTypes = {"image/png", "image/jpg", "image/jpeg", "image/gif"},
     *      mimeTypesMessage = "Le format {{ type }} n'est pas autorisé, formats autorisés: {{ types }}",
     * )
     */
    private $logoFile;

    /**
     * @ORM\ManyToMany(targetEntity=Project::class, inversedBy="technos")
     */
    private $project;

    /**
     * @ORM\Column(type="datetime")
     * @var \Datetime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->project = new ArrayCollection();
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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function setLogoFile(File $image = null): void
    {
        $this->logoFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProject(Project $project): self
    {
        if (!$this->project->contains($project)) {
            $this->project[] = $project;
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        $this->project->removeElement($project);

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
}
