<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LieuRepository::class)
 */
class Lieu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @var string
     */
    private string $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private string $rue;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     */
    private float $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     */
    private float $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="lieux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="lieu")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sorties;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Ville
     */
    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    /**
     * @param Ville $ville
     */
    public function setVille(?Ville $ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return Sortie
     */
    public function getSorties(): Sortie
    {
        return $this->sorties;
    }

    /**
     * @param Sortie $sorties
     */
    public function setSorties(Sortie $sorties): void
    {
        $this->sorties = $sorties;
    }


}
