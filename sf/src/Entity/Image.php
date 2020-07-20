<?php

namespace App\Entity;

use App\Repository\ImageRepository;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @Vich\Uploadable()
 */
class Image
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
    private $name;


    /**
     * @var File|null
     * @Assert\Image(mimeTypes={"image/jpeg", "image/jpg", "image/png"})
     * @Vich\UploadableField(mapping="uploaded", fileNameProperty="imageName")
     *
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string")
     *
     * @var string|null
     */
    private $imageName;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="image")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=GenderCat::class, mappedBy="headerBg")
     */
    private $genderCats;

    /**
     * @ORM\OneToMany(targetEntity=MainConfig::class, mappedBy="headerBg")
     */
    private $mainConfigs;

    /**
     * @ORM\OneToMany(targetEntity=SiteConfig::class, mappedBy="howWorksBg")
     */
    private $siteConfigs;

    /**
     * @ORM\OneToMany(targetEntity=Partners::class, mappedBy="logo")
     */
    private $partners;

    /**
     * @ORM\OneToMany(targetEntity=Features::class, mappedBy="img")
     */
    private $features;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->genderCats = new ArrayCollection();
        $this->mainConfigs = new ArrayCollection();
        $this->siteConfigs = new ArrayCollection();
        $this->partners = new ArrayCollection();
        $this->features = new ArrayCollection();
    }

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    /**
     * @param File|null $imageFile
     *
     * @throws Exception
     */
    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        //return $this;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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
            $product->setImage($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getImage() === $this) {
                $product->setImage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GenderCat[]
     */
    public function getGenderCats(): Collection
    {
        return $this->genderCats;
    }

    public function addGenderCat(GenderCat $genderCat): self
    {
        if (!$this->genderCats->contains($genderCat)) {
            $this->genderCats[] = $genderCat;
            $genderCat->setHeaderBg($this);
        }

        return $this;
    }

    public function removeGenderCat(GenderCat $genderCat): self
    {
        if ($this->genderCats->contains($genderCat)) {
            $this->genderCats->removeElement($genderCat);
            // set the owning side to null (unless already changed)
            if ($genderCat->getHeaderBg() === $this) {
                $genderCat->setHeaderBg(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MainConfig[]
     */
    public function getMainConfigs(): Collection
    {
        return $this->mainConfigs;
    }

    public function addMainConfig(MainConfig $mainConfig): self
    {
        if (!$this->mainConfigs->contains($mainConfig)) {
            $this->mainConfigs[] = $mainConfig;
            $mainConfig->setHeaderBg($this);
        }

        return $this;
    }

    public function removeMainConfig(MainConfig $mainConfig): self
    {
        if ($this->mainConfigs->contains($mainConfig)) {
            $this->mainConfigs->removeElement($mainConfig);
            // set the owning side to null (unless already changed)
            if ($mainConfig->getHeaderBg() === $this) {
                $mainConfig->setHeaderBg(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SiteConfig[]
     */
    public function getSiteConfigs(): Collection
    {
        return $this->siteConfigs;
    }

    public function addSiteConfig(SiteConfig $siteConfig): self
    {
        if (!$this->siteConfigs->contains($siteConfig)) {
            $this->siteConfigs[] = $siteConfig;
            $siteConfig->setHowWorksBg($this);
        }

        return $this;
    }

    public function removeSiteConfig(SiteConfig $siteConfig): self
    {
        if ($this->siteConfigs->contains($siteConfig)) {
            $this->siteConfigs->removeElement($siteConfig);
            // set the owning side to null (unless already changed)
            if ($siteConfig->getHowWorksBg() === $this) {
                $siteConfig->setHowWorksBg(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Partners[]
     */
    public function getPartners(): Collection
    {
        return $this->partners;
    }

    public function addPartner(Partners $partner): self
    {
        if (!$this->partners->contains($partner)) {
            $this->partners[] = $partner;
            $partner->setLogo($this);
        }

        return $this;
    }

    public function removePartner(Partners $partner): self
    {
        if ($this->partners->contains($partner)) {
            $this->partners->removeElement($partner);
            // set the owning side to null (unless already changed)
            if ($partner->getLogo() === $this) {
                $partner->setLogo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Features[]
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    public function addFeature(Features $feature): self
    {
        if (!$this->features->contains($feature)) {
            $this->features[] = $feature;
            $feature->setImg($this);
        }

        return $this;
    }

    public function removeFeature(Features $feature): self
    {
        if ($this->features->contains($feature)) {
            $this->features->removeElement($feature);
            // set the owning side to null (unless already changed)
            if ($feature->getImg() === $this) {
                $feature->setImg(null);
            }
        }

        return $this;
    }

}
