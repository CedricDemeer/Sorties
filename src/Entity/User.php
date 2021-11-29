<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"})
 * @Vich\Uploadable
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private string $Nom;

    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     */
    private string $Prenom;

    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     */
    private string $pseudo;

    /**
     * @var string
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private string $telephone;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private bool $administrateur;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private bool $actif;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=300, nullable=true)
     */
    private ?string $photo;


    /**
     * @ORM\ManyToMany(targetEntity=Sortie::class, mappedBy="users")
     * @ORM\JoinColumn(nullable=true)
     */
    private  $sorties;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="organisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sortiesOrga;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Campus", inversedBy="Users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campus;

    /**
     * @Vich\UploadableField(mapping="profils_images", fileNameProperty="photo")
     * @var File|null
     */
    private ?File $photoFile;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;


    #[Pure] public function __construct()
    {
        $this->sorties = new ArrayCollection();
        //$this->photoFile = new File('uploads/images/profils/profil.html.twig-vide.png');

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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
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
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdministrateur(): bool
    {
        return $this->administrateur;
    }

    public function setAdministrateur(bool $administrateur): self
    {
        $this->administrateur = $administrateur;
        /*if($administrateur)
        {
            $this->setRoles(['ROLE_ADMIN']);
        }else{
            $this->setRoles(['ROLE_USER']);
        }*/


        return $this;
    }

    public function getActif(): bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Sortie
     */
    public function getSortiesOrga(): Sortie
    {
        return $this->sortiesOrga;
    }

    /**
     * @param Sortie $sortiesOrga
     */
    public function setSortiesOrga(Sortie $sortiesOrga): void
    {
        $this->sortiesOrga = $sortiesOrga;
    }

    /**
     * @return Sortie
     */
    public function getSorties(): ArrayCollection
    {
        return $this->sorties;
    }

    /**
     * @param Sortie $sorties
     */
    public function setSorties(ArrayCollection $sorties): void
    {
        $this->sorties = $sorties;
    }

    public function addSortie(Sortie $sortie): self
    {
        if (!$this->sorties->contains($sortie)) {
            $this->sorties[] = $sortie;
            $sortie->addUser($this);
        }
        return $this;
    }
    public function removeSortie(Sortie $sortie): self
    {
        if ($this->sorties->contains($sortie)) {
            $this->sorties->removeElement($sortie);
            $sortie->removeUser($this);
        }
        return $this;
    }
    /**
     * @return mixed
     */
    public function getPhoto(): ? string
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     * @param mixed $campus
     */
    public function setCampus($campus): void
    {
        $this->campus = $campus;
    }

    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    public function setPhotoFile(?File $image = null): void
    {
        $this->photoFile = $image;
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();

        }
    }
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->Nom,
            $this->Prenom,
            $this->pseudo,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->Nom,
            $this->Prenom,
            $this->pseudo,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }


}
