<?php

namespace App\Entity;

use App\Repository\MainConfigRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MainConfigRepository::class)
 */
class MainConfig
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Image::class, inversedBy="mainConfigs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $headerBg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headerTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headerSub;

    /**
     * @ORM\ManyToOne(targetEntity=Image::class, inversedBy="mainConfigs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender1Bg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender1Title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender1Slug;

    /**
     * @ORM\ManyToOne(targetEntity=Image::class, inversedBy="mainConfigs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gender2Bg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender2Title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gender2Slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeaderBg(): ?Image
    {
        return $this->headerBg;
    }

    public function setHeaderBg(?Image $headerBg): self
    {
        $this->headerBg = $headerBg;

        return $this;
    }

    public function getHeaderTitle(): ?string
    {
        return $this->headerTitle;
    }

    public function setHeaderTitle(string $headerTitle): self
    {
        $this->headerTitle = $headerTitle;

        return $this;
    }

    public function getHeaderSub(): ?string
    {
        return $this->headerSub;
    }

    public function setHeaderSub(string $headerSub): self
    {
        $this->headerSub = $headerSub;

        return $this;
    }

    public function getGender1Bg(): ?Image
    {
        return $this->gender1Bg;
    }

    public function setGender1Bg(?Image $gender1Bg): self
    {
        $this->gender1Bg = $gender1Bg;

        return $this;
    }

    public function getGender1Title(): ?string
    {
        return $this->gender1Title;
    }

    public function setGender1Title(string $gender1Title): self
    {
        $this->gender1Title = $gender1Title;

        return $this;
    }

    public function getGender1Slug(): ?string
    {
        return $this->gender1Slug;
    }

    public function setGender1Slug(string $gender1Slug): self
    {
        $this->gender1Slug = $gender1Slug;

        return $this;
    }

    public function getGender2Bg(): ?Image
    {
        return $this->gender2Bg;
    }

    public function setGender2Bg(?Image $gender2Bg): self
    {
        $this->gender2Bg = $gender2Bg;

        return $this;
    }

    public function getGender2Title(): ?string
    {
        return $this->gender2Title;
    }

    public function setGender2Title(string $gender2Title): self
    {
        $this->gender2Title = $gender2Title;

        return $this;
    }

    public function getGender2Slug(): ?string
    {
        return $this->gender2Slug;
    }

    public function setGender2Slug(string $gender2Slug): self
    {
        $this->gender2Slug = $gender2Slug;

        return $this;
    }
}
