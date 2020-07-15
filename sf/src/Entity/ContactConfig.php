<?php

namespace App\Entity;

use App\Repository\ContactConfigRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactConfigRepository::class)
 */
class ContactConfig
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $infoMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $customerMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salesMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pressMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $instagramm;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pinterest;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $facebook;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInfoMail(): ?string
    {
        return $this->infoMail;
    }

    public function setInfoMail(string $infoMail): self
    {
        $this->infoMail = $infoMail;

        return $this;
    }

    public function getCustomerMail(): ?string
    {
        return $this->customerMail;
    }

    public function setCustomerMail(string $customerMail): self
    {
        $this->customerMail = $customerMail;

        return $this;
    }

    public function getSalesMail(): ?string
    {
        return $this->salesMail;
    }

    public function setSalesMail(string $salesMail): self
    {
        $this->salesMail = $salesMail;

        return $this;
    }

    public function getPressMail(): ?string
    {
        return $this->pressMail;
    }

    public function setPressMail(string $pressMail): self
    {
        $this->pressMail = $pressMail;

        return $this;
    }

    public function getInstagramm(): ?string
    {
        return $this->instagramm;
    }

    public function setInstagramm(string $instagramm): self
    {
        $this->instagramm = $instagramm;

        return $this;
    }

    public function getPinterest(): ?string
    {
        return $this->pinterest;
    }

    public function setPinterest(string $pinterest): self
    {
        $this->pinterest = $pinterest;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }
}
