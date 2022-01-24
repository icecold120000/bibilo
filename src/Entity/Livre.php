<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 */
class Livre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $titreLivre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $genreLivre;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTime $dateLivre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $afficheLivre;

    /**
     * @ORM\ManyToOne(targetEntity=Bibliothecque::class, inversedBy="livres")
     */
    private $bibliothecque;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $noteLivre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $commentaireLivre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreLivre(): ?string
    {
        return $this->titreLivre;
    }

    public function setTitreLivre(string $titreLivre): self
    {
        $this->titreLivre = $titreLivre;

        return $this;
    }

    public function getGenreLivre(): ?string
    {
        return $this->genreLivre;
    }

    public function setGenreLivre(string $genreLivre): self
    {
        $this->genreLivre = $genreLivre;

        return $this;
    }

    public function getDateLivre(): ?\DateTime
    {
        return $this->dateLivre;
    }

    public function setDateLivre(\DateTime $dateLivre): self
    {
        $this->dateLivre = $dateLivre;

        return $this;
    }

    public function getAfficheLivre(): ?string
    {
        return $this->afficheLivre;
    }

    public function setAfficheLivre(string $afficheLivre): self
    {
        $this->afficheLivre = $afficheLivre;

        return $this;
    }

    public function getBibliothecque(): ?Bibliothecque
    {
        return $this->bibliothecque;
    }

    public function setBibliothecque(?Bibliothecque $bibliothecque): self
    {
        $this->bibliothecque = $bibliothecque;

        return $this;
    }

    public function getNoteLivre(): ?int
    {
        return $this->noteLivre;
    }

    public function setNoteLivre(int $noteLivre): self
    {
        $this->noteLivre = $noteLivre;

        return $this;
    }

    public function getCommentaireLivre(): ?string
    {
        return $this->commentaireLivre;
    }

    public function setCommentaireLivre(?string $commentaireLivre): self
    {
        $this->commentaireLivre = $commentaireLivre;

        return $this;
    }
}
