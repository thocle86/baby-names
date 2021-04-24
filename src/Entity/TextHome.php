<?php

namespace App\Entity;

use App\Repository\TextHomeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TextHomeRepository::class)
 */
class TextHome
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
     *      minMessage = "Le titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le titre ne peut pas faire plus de {{ limit }} caractères"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @var string
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Le titre doit faire au moins {{ limit }} caractères"
     * )
     */
    private $text;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     */
    private $position;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

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
