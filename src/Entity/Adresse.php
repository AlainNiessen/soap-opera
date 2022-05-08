<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank (message = "Dieses Feld muss ausgefüllt werden!")
     * @Assert\NotNull (message = "Dieses Feld muss ausgefüllt werden!")
     * @ORM\Column(type="string", length=255)
     */
    private $numeroRue;

    /**
     * @Assert\NotBlank (message = "Dieses Feld muss ausgefüllt werden!")
     * @Assert\NotNull (message = "Dieses Feld muss ausgefüllt werden!")
     * @Assert\Length(
     *      min = 4,
     *      max = 5,
     *      minMessage = "Die Postleitzahl muss mindestens {{ limit }} Zeichen lang sein!",
     *      maxMessage = "Die Postleitzahl kann höchstens {{ limit }} Zeichen lang sein!")
     * @Assert\Regex(
     *      "/^^[0-9]*$/",
     *      match = true, 
     *      message="Die Postleitzahl kann nur aus Ziffern bestehen!")
     * @ORM\Column(type="string", length=255)
     */
    private $codePostal;

    /**
     * @ORM\OneToMany(targetEntity=Partenaire::class, mappedBy="adresse")
     */
    private $partenaire;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="adresseHome")
     */
    private $utilisateursHome;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="adresseDeliver")
     */
    private $utilisateurDeliver;    

    /**
     * @Assert\NotBlank (message = "Dieses Feld muss ausgefüllt werden!")
     * @Assert\NotNull (message = "Dieses Feld muss ausgefüllt werden!")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Die Straße muss mindestens {{ limit }} Zeichen lang sein!")
     * @ORM\Column(type="string", length=255)
     */
    private $rue;

    /**
     * @Assert\NotBlank (message = "Dieses Feld muss ausgefüllt werden!")
     * @Assert\NotNull (message = "Dieses Feld muss ausgefüllt werden!")
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "Die Stadt muss mindestens {{ limit }} Zeichen lang sein!")
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @Assert\NotBlank (message = "Dieses Feld muss ausgefüllt werden!")
     * @Assert\NotNull (message = "Dieses Feld muss ausgefüllt werden!")
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->rue.', '.$this->numeroRue.' | '.$this->codePostal.' - '.$this->ville.' | '.$this->ville;
    }

    public function __construct()
    {
        $this->partenaire = new ArrayCollection();
        $this->utilisateursHome = new ArrayCollection();
        $this->utilisateurDeliver = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroRue(): ?string
    {
        return $this->numeroRue;
    }

    public function setNumeroRue(string $numeroRue): self
    {
        $this->numeroRue = $numeroRue;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection<int, Partenaire>
     */
    public function getPartenaire(): Collection
    {
        return $this->partenaire;
    }

    public function addPartenaire(Partenaire $partenaire): self
    {
        if (!$this->partenaire->contains($partenaire)) {
            $this->partenaire[] = $partenaire;
            $partenaire->setAdresse($this);
        }

        return $this;
    }

    public function removePartenaire(Partenaire $partenaire): self
    {
        if ($this->partenaire->removeElement($partenaire)) {
            // set the owning side to null (unless already changed)
            if ($partenaire->getAdresse() === $this) {
                $partenaire->setAdresse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateursHome(): Collection
    {
        return $this->utilisateursHome;
    }

    public function addUtilisateursHome(Utilisateur $utilisateursHome): self
    {
        if (!$this->utilisateursHome->contains($utilisateursHome)) {
            $this->utilisateursHome[] = $utilisateursHome;
            $utilisateursHome->setAdresseHome($this);
        }

        return $this;
    }

    public function removeUtilisateursHome(Utilisateur $utilisateursHome): self
    {
        if ($this->utilisateursHome->removeElement($utilisateursHome)) {
            // set the owning side to null (unless already changed)
            if ($utilisateursHome->getAdresseHome() === $this) {
                $utilisateursHome->setAdresseHome(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurDeliver(): Collection
    {
        return $this->utilisateurDeliver;
    }

    public function addUtilisateurDeliver(Utilisateur $utilisateurDeliver): self
    {
        if (!$this->utilisateurDeliver->contains($utilisateurDeliver)) {
            $this->utilisateurDeliver[] = $utilisateurDeliver;
            $utilisateurDeliver->setAdresseDeliver($this);
        }

        return $this;
    }

    public function removeUtilisateurDeliver(Utilisateur $utilisateurDeliver): self
    {
        if ($this->utilisateurDeliver->removeElement($utilisateurDeliver)) {
            // set the owning side to null (unless already changed)
            if ($utilisateurDeliver->getAdresseDeliver() === $this) {
                $utilisateurDeliver->setAdresseDeliver(null);
            }
        }

        return $this;
    }

    

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }
}
