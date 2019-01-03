<?php

namespace SnowTrick\TrickBundle\Entity;

use App\Entity\Category;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="SnowTrick\TrickBundle\Repository\TrickRepository")
 */
class Trick
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\Column(type="json")
     */
    private $imageList = [];

    /**
     * @ORM\Column(type="json")
     */
    private $videoList = [];


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategorie(): ?Category
    {
        return $this->categorie;
    }

    public function setCategorie(?Category $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getImageList(): ?array
    {
        return $this->imageList;
    }

    public function setImageList(array $imageList): self
    {
        $this->imageList = $imageList;

        return $this;
    }

    public function getVideoList(): ?array
    {
        return $this->videoList;
    }

    public function setVideoList(array $videoList): self
    {
        $this->videoList = $videoList;

        return $this;
    }




}
