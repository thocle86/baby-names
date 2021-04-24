<?php

namespace App\Entity;

use App\Repository\AboutMeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=AboutMeRepository::class)
 * @Vich\Uploadable
 */
class AboutMe
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
    private $avatar;

    /**
     * @Vich\UploadableField(mapping="about-me_file", fileNameProperty="avatar")
     * @var File
     * @Assert\File(
     *      maxSize = "100k",
     *      maxSizeMessage = "Le fichier est trop lourd ({{ size }}{{ suffix }}), {{ limit }}{{ suffix }} maximum",
     *      mimeTypes = {"image/png", "image/jpg", "image/jpeg", "image/gif"},
     *      mimeTypesMessage = "Le format {{ type }} n'est pas autorisé, formats autorisés: {{ types }}",
     * )
     */
    private $avatarFile;

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
    private $myJob;

    /**
     * @ORM\Column(type="string", length=15)
     * @var string
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 15,
     *      minMessage = "L'année doit faire au moins {{ limit }} caractères",
     *      maxMessage = "L'année ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private $copyrightYear;

    /**
     * @ORM\Column(type="datetime")
     * @var \Datetime
     */
    private $updatedAt;

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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function setAvatarFile(File $image = null): void
    {
        $this->avatarFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    public function getMyJob(): ?string
    {
        return $this->myJob;
    }

    public function setMyJob(string $myJob): self
    {
        $this->myJob = $myJob;

        return $this;
    }

    public function getCopyrightYear(): ?string
    {
        return $this->copyrightYear;
    }

    public function setCopyrightYear(string $copyrightYear): self
    {
        $this->copyrightYear = $copyrightYear;

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
