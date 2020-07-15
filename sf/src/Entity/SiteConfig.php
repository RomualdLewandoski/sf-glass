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
     * @ORM\ManyToOne(targetEntity=Image::class, inversedBy="siteConfigs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $howWorksBg;

    /**
     * @ORM\Column(type="text")
     */
    private $howWorks;

    /**
     * @ORM\Column(type="text")
     */
    private $seenOnPress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mapsUrl;





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

    public function getHowWorksBg(): ?Image
    {
        return $this->howWorksBg;
    }

    public function setHowWorksBg(?Image $howWorksBg): self
    {
        $this->howWorksBg = $howWorksBg;

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

    public function getSeenOnPress(): ?string
    {
        return $this->seenOnPress;
    }

    public function setSeenOnPress(string $seenOnPress): self
    {
        $this->seenOnPress = $seenOnPress;

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


}
