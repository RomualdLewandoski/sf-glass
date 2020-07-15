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
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=CatProduct::class, mappedBy="gender")
     */
    private $catProducts;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="gender")
     */
    private $products;

    /**
     * @ORM\ManyToOne(targetEntity=Image::class, inversedBy="genderCats")
     */
    private $headerBg;

    public function __construct()
    {
        $this->catProducts = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setGender($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getGender() === $this) {
                $product->setGender(null);
            }
        }

        return $this;
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

}
