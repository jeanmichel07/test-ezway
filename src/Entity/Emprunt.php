<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpruntRepository::class)
 */
class Emprunt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Livre::class, inversedBy="emprunts")
     */
    private $livre;

    /**
     * @ORM\ManyToOne(targetEntity=Abonne::class, inversedBy="emprunts")
     */
    private $abonne;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_sortie;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_rendu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    public function getAbonne(): ?Abonne
    {
        return $this->abonne;
    }

    public function setAbonne(?Abonne $abonne): self
    {
        $this->abonne = $abonne;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(?\DateTimeInterface $date_sortie): self
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getDateRendu(): ?\DateTimeInterface
    {
        return $this->date_rendu;
    }

    public function setDateRendu(?\DateTimeInterface $date_rendu): self
    {
        $this->date_rendu = $date_rendu;

        return $this;
    }
}
