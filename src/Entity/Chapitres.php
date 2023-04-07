<?php

namespace App\Entity;

use App\Repository\ChapitresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChapitresRepository::class)]
class Chapitres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\ManyToOne(inversedBy: 'chapitres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $cours = null;

    #[ORM\OneToMany(mappedBy: 'chapitre', targetEntity: UtilisateursChapitres::class, orphanRemoval: true)]
    private Collection $utilisateursChapitres;

    public function __construct()
    {
        $this->utilisateursChapitres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }

    /**
     * @return Collection<int, UtilisateursChapitres>
     */
    public function getUtilisateursChapitres(): Collection
    {
        return $this->utilisateursChapitres;
    }

    public function addUtilisateursChapitre(UtilisateursChapitres $utilisateursChapitre): self
    {
        if (!$this->utilisateursChapitres->contains($utilisateursChapitre)) {
            $this->utilisateursChapitres->add($utilisateursChapitre);
            $utilisateursChapitre->setChapitre($this);
        }

        return $this;
    }

    public function removeUtilisateursChapitre(UtilisateursChapitres $utilisateursChapitre): self
    {
        if ($this->utilisateursChapitres->removeElement($utilisateursChapitre)) {
            // set the owning side to null (unless already changed)
            if ($utilisateursChapitre->getChapitre() === $this) {
                $utilisateursChapitre->setChapitre(null);
            }
        }

        return $this;
    }
}
