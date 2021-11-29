<?php


namespace App\Modele;

use Doctrine\ORM\Mapping as ORM;

class FiltreSortie
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campus", inversedBy="sorties")
     */
    private $campus;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Categorie", inversedBy="sorties")
     */
    private $categorie;

    /**
     * @var string
     */
    private ?string $champSaisie = null;


    /**
     * @ORM\Column(type="datetime")
     */
    private $dateintervalmin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateintervalmax;

    /**
     * @var bool
     */
    private bool $sortieOrga = false;

    /**
     * @var bool
     */
    private bool $sortieInscrit = false;

    /**
     * @var bool
     */
    private bool $sortieNonInscrit = false;

    /**
     * @var bool
     */
    private bool $sortiePassee = false;

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

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie): void
    {
        $this->categorie = $categorie;
    }

    /**
     * @return string
     */
    public function getChampSaisie(): ?string
    {
        return $this->champSaisie;
    }

    /**
     * @param string $champSaisie
     */
    public function setChampSaisie(string $champSaisie): void
    {
        $this->champSaisie = $champSaisie;
    }

    /**
     * @return mixed
     */
    public function getDateintervalmin()
    {
        return $this->dateintervalmin;
    }

    /**
     * @param mixed $dateintervalmin
     */
    public function setDateintervalmin($dateintervalmin): void
    {
        $this->dateintervalmin = $dateintervalmin;
    }

    /**
     * @return mixed
     */
    public function getDateintervalmax()
    {
        return $this->dateintervalmax;
    }

    /**
     * @param mixed $dateintervalmax
     */
    public function setDateintervalmax($dateintervalmax): void
    {
        $this->dateintervalmax = $dateintervalmax;
    }

    /**
     * @return bool
     */
    public function isSortieOrga(): bool
    {

        return $this->sortieOrga;
    }

    /**
     * @param bool $sortieOrga
     */
    public function setSortieOrga(bool $sortieOrga): void
    {
        $this->sortieOrga = $sortieOrga;
    }

    /**
     * @return bool
     */
    public function isSortieInscrit(): bool
    {
        return $this->sortieInscrit;
    }

    /**
     * @param bool $sortieInscrit
     */
    public function setSortieInscrit(bool $sortieInscrit): void
    {
        $this->sortieInscrit = $sortieInscrit;
    }

    /**
     * @return bool
     */
    public function isSortieNonInscrit(): bool
    {
        return $this->sortieNonInscrit;
    }

    /**
     * @param bool $sortieNonInscrit
     */
    public function setSortieNonInscrit(bool $sortieNonInscrit): void
    {
        $this->sortieNonInscrit = $sortieNonInscrit;
    }

    /**
     * @return bool
     */
    public function isSortiePassee(): bool
    {
        return $this->sortiePassee;
    }

    /**
     * @param bool $sortiePassee
     */
    public function setSortiePassee(bool $sortiePassee): void
    {
        $this->sortiePassee = $sortiePassee;
    }



}