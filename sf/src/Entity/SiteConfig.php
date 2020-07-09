<?php

namespace App\Entity;

use App\Repository\SiteConfigRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SiteConfigRepository::class)
 */
class SiteConfig
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $learnMore;

    /**
     * @ORM\Column(type="text")
     */
    private $careAndTips;

    /**
     * @ORM\Column(type="text")
     */
    private $howWorks;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $howWorksBg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headerBg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headerTitle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headerSubtile;

    /**
     * @ORM\Column(type="text")
     */
    private $seeenOnPress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mapsUrl;

    /**
     * @ORM\Column(type="text")
     */
    private $aboutUs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLearnMore(): ?string
    {
        return $this->learnMore;
    }

    public function setLearnMore(string $learnMore): self
    {
        $this->learnMore = $learnMore;

        return $this;
    }

    public function getCareAndTips(): ?string
    {
        return $this->careAndTips;
    }

    public function setCareAndTips(string $careAndTips): self
    {
        $this->careAndTips = $careAndTips;

        return $this;
    }

    public function getHowWorks(): ?string
    {
        return $this->howWorks;
    }

    public function setHowWorks(string $howWorks): self
    {
        $this->howWorks = $howWorks;

        return $this;
    }

    public function getHowWorksBg(): ?string
    {
        return $this->howWorksBg;
    }

    public function setHowWorksBg(string $howWorksBg): self
    {
        $this->howWorksBg = $howWorksBg;

        return $this;
    }

    public function getHeaderBg(): ?string
    {
        return $this->headerBg;
    }

    public function setHeaderBg(string $headerBg): self
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

    public function getHeaderSubtile(): ?string
    {
        return $this->headerSubtile;
    }

    public function setHeaderSubtile(string $headerSubtile): self
    {
        $this->headerSubtile = $headerSubtile;

        return $this;
    }

    public function getSeeenOnPress(): ?string
    {
        return $this->seeenOnPress;
    }

    public function setSeeenOnPress(string $seeenOnPress): self
    {
        $this->seeenOnPress = $seeenOnPress;

        return $this;
    }

    public function getMapsUrl(): ?string
    {
        return $this->mapsUrl;
    }

    public function setMapsUrl(string $mapsUrl): self
    {
        $this->mapsUrl = $mapsUrl;

        return $this;
    }

    public function getAboutUs(): ?string
    {
        return $this->aboutUs;
    }

    public function setAboutUs(string $aboutUs): self
    {
        $this->aboutUs = $aboutUs;

        return $this;
    }
}
