<?php

namespace App\Entity;

use App\Repository\AboutMeRepository;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $myJobTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $myJobText;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $myNewsTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $myNewsText;

    public function getId(): ?int
    {
        return $this->id;
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
}
