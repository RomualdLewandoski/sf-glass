<?php

namespace App\Entity;

use App\Repository\GenderCatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GenderCatRepository::class)
 */
class GenderCat
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $headerBg;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=CatProduct::class, mappedBy="gender")
     */
    private $catProducts;

    public function __construct()
    {
        $this->catProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|CatProduct[]
     */
    public function getCatProducts(): Collection
    {
        return $this->catProducts;
    }

    public function addCatProduct(CatProduct $catProduct): self
    {
        if (!$this->catProducts->contains($catProduct)) {
            $this->catProducts[] = $catProduct;
            $catProduct->setGender($this);
        }

        return $this;
    }

    public function removeCatProduct(CatProduct $catProduct): self
    {
        if ($this->catProducts->contains($catProduct)) {
            $this->catProducts->removeElement($catProduct);
            // set the owning side to null (unless already changed)
            if ($catProduct->getGender() === $this) {
                $catProduct->setGender(null);
            }
        }

        return $this;
    }
}
