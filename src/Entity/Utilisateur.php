<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Email (message = "utilisateur.email.valide")
     * @Assert\NotBlank (message = "utilisateur.email.not_blank")
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\NotBlank (message = "utilisateur.nom.not_blank")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "utilisateur.nom.length_min")
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @Assert\NotBlank (message = "utilisateur.prenom.not_blank")
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "utilisateur.prenom.length_min")
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @Assert\NotBlank (message = "utilisateur.dateNaissance.not_blank")
     * @ORM\Column(type="datetime")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inscriptionValide;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $inscriptionToken;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="utilisateursHome")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresseHome;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="utilisateurDeliver")
     */
    private $adresseDeliver;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, inversedBy="utilisateurs")
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="utilisateur")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="utilisateur")
     */
    private $factures;

    /**
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="utilisateurs")
     */
    private $langue;

    //mot de passe clair qui doit contenir au moins une lettre, un chiffre et un caractére spécial et au moins 6 caractéres  
    // doit contenir (match = false => ne peut pas contenir)
    /**
     * @Assert\NotBlank (message = "utilisateur.plainPassword.not_blank", groups={"inscription", "reset"})
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "utilisateur.plainPassword.length_min",
     *      groups={"inscription", "reset"})
     * @Assert\Regex(
     *      "/^(?=.*[A-Za-z])(?=.*\d)(?=.*\W)/",
     *      match = true, 
     *      message="utilisateur.plainPassword.regex",
     *      groups={"inscription", "reset"})
     */ 
    private $plainPassword;

    /**
     * @ORM\ManyToMany(targetEntity=NewsletterCategorie::class, inversedBy="utilisateurs")
     */
    private $newsletterCategories;

    /**
     * @ORM\OneToMany(targetEntity=Evaluation::class, mappedBy="utilisateur")
     */
    private $evaluations;

    /**
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "utilisateur.nomEntreprise.length_min")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomEntreprise;

    /**
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "utilisateur.numeroTVA.length_min")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroTVA;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ramassage = false;

    // AFFICHAGE DANS INTERFACE ADMIN
    public function __toString(): string
    {
        return $this->nom.' '.$this->prenom;
    }

    public function __construct()
    {
        $this->dateInscription = new \DateTime();
        $this->articles = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->newsletterCategories = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getInscriptionValide(): ?bool
    {
        return $this->inscriptionValide;
    }

    public function setInscriptionValide(bool $inscriptionValide): self
    {
        $this->inscriptionValide = $inscriptionValide;

        return $this;
    }

    public function getInscriptionToken(): ?string
    {
        return $this->inscriptionToken;
    }

    public function setInscriptionToken(?string $inscriptionToken): self
    {
        $this->inscriptionToken = $inscriptionToken;

        return $this;
    }

    public function getAdresseHome(): ?Adresse
    {
        return $this->adresseHome;
    }

    public function setAdresseHome(?Adresse $adresseHome): self
    {
        $this->adresseHome = $adresseHome;

        return $this;
    }

    public function getAdresseDeliver(): ?Adresse
    {
        return $this->adresseDeliver;
    }

    public function setAdresseDeliver(?Adresse $adresseDeliver): self
    {
        $this->adresseDeliver = $adresseDeliver;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        $this->articles->removeElement($article);

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUtilisateur() === $this) {
                $commentaire->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setUtilisateur($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getUtilisateur() === $this) {
                $facture->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getLangue(): ?Langue
    {
        return $this->langue;
    }

    public function setLangue(?Langue $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return Collection<int, NewsletterCategorie>
     */
    public function getNewsletterCategories(): Collection
    {
        return $this->newsletterCategories;
    }

    public function addNewsletterCategory(NewsletterCategorie $newsletterCategory): self
    {
        if (!$this->newsletterCategories->contains($newsletterCategory)) {
            $this->newsletterCategories[] = $newsletterCategory;
            //$newsletterCategory->addUtilisateur($this);
        }

        return $this;
    }

    public function removeNewsletterCategory(NewsletterCategorie $newsletterCategory): self
    {
        $this->newsletterCategories->removeElement($newsletterCategory); 

        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations[] = $evaluation;
            $evaluation->setUtilisateur($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): self
    {
        if ($this->evaluations->removeElement($evaluation)) {
            // set the owning side to null (unless already changed)
            if ($evaluation->getUtilisateur() === $this) {
                $evaluation->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(?string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getNumeroTVA(): ?string
    {
        return $this->numeroTVA;
    }

    public function setNumeroTVA(?string $numeroTVA): self
    {
        $this->numeroTVA = $numeroTVA;

        return $this;
    }

    public function getRamassage(): ?bool
    {
        return $this->ramassage;
    }

    public function setRamassage(?bool $ramassage): self
    {
        $this->ramassage = $ramassage;

        return $this;
    }
}
