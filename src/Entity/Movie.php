<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Movie
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
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="movies", cascade={"persist"})
     */
    private $genres;

    /**
     * @ORM\OneToMany(targetEntity=Employment::class, mappedBy="movie", orphanRemoval=true)
     */
    private $employments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->createdAt=new \DateTime();
        $this->employments = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    /**
     * @Groups({"movie_browse","movie_read"})
     */

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @Groups({"movie_browse","movie_read"})
     */

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }


    /**
     * @Groups({"movie_browse","movie_read"})
     */

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    /**
     * @Groups({"movie_browse","movie_read"})
     */

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
     * @Groups("movie_read")
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {

        //parce que le Populator de Faker est peu simplet, il n'exécute pas le contstructeur, on va initialiser la propriété $genres si elle est nulle
        if($this->genres==null){
            $this->genres=new ArrayCollection();
        }
        
        
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection|Employment[]
     */
    public function getEmployments(): Collection
    {
        return $this->employments;
    }

    public function getActors(){

        $list=[];
        foreach($this->employments as $employment){
            if ($employment instanceof Actor){
                $list[]=$employment;
            }
        }

        return $list;
    }

    public function getCrewMembers(){

        $list=[];
        foreach($this->employments as $employment){
            if ($employment instanceof CrewMember){
                $list[]=$employment;
            }
        }

        return $list;
    }

    public function getDirectors(){

        $list=[];
        foreach($this->employments as $employment){
            if ($employment instanceof Director){
                $list[]=$employment;
            }
        }

        return $list;
    }

    public function addEmployment(Employment $employment): self
    {
        if (!$this->employments->contains($employment)) {
            $this->employments[] = $employment;
            $employment->setMovie($this);
        }

        return $this;
    }

    public function removeEmployment(Employment $employment): self
    {
        if ($this->employments->removeElement($employment)) {
            // set the owning side to null (unless already changed)
            if ($employment->getMovie() === $this) {
                $employment->setMovie(null);
            }
        }

        return $this;
    }


     /**
     * @Groups({"movie_browse","movie_read"})
     */

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }


    /**
     * @ORM\PreUpdate
     */

    public function onPreUpdate()
    {
       $this->updatedAt=new \DateTime();
    }
}
