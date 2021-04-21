<?php

namespace App\Entity;

use App\Repository\AboutMeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AboutMeRepository::class)
 */
class AboutMe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le chemin vers le fichier est trop long, il dépasse {{ limit }} caractères"
     * )
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le titre ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private $myJobTitle;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 1000,
     *      minMessage = "Le texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private $myJobText;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Le titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le titre ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private $myNewsTitle;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 1000,
     *      minMessage = "Le texte doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le texte ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private $myNewsText;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $copyrightYear;

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

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getMyJobTitle(): ?string
    {
        return $this->myJobTitle;
    }

    public function setMyJobTitle(string $myJobTitle): self
    {
        $this->myJobTitle = $myJobTitle;

        return $this;
    }

    public function getMyJobText(): ?string
    {
        return $this->myJobText;
    }

    public function setMyJobText(string $myJobText): self
    {
        $this->myJobText = $myJobText;

        return $this;
    }

    public function getMyNewsTitle(): ?string
    {
        return $this->myNewsTitle;
    }

    public function setMyNewsTitle(string $myNewsTitle): self
    {
        $this->myNewsTitle = $myNewsTitle;

        return $this;
    }

    public function getMyNewsText(): ?string
    {
        return $this->myNewsText;
    }

    public function setMyNewsText(string $myNewsText): self
    {
        $this->myNewsText = $myNewsText;

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
}
