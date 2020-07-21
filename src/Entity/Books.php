<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=BooksRepository::class)
 */
class Books
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Ce champs est nécessaire !")
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPages;


    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank(message = "Ce champs est nécessaire !")
     */
    private $resume;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genre;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;


    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getNbPages()
    {
        return $this->nbPages;
    }

    public function setNbPages($nbPages): self
    {
        $this->nbPages = $nbPages;

        return $this;
    }
    

    /**
     * @return mixed
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * @param mixed $resume
     */
    public function setResume($resume): void
    {
        $this->resume = $resume;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

}
