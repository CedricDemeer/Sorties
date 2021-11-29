<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Entity\User;
use App\Modele\FiltreSortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }


    /**
     * @param FiltreSortie|null $filtre
     * @param UserInterface $user
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function findByFilter(FiltreSortie $filtre = null, User $user)
    {

        $today = new \DateTime();

        $userId = $user -> getId();

        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->andWhere('s.statut != 4')
            ->join('s.statut', 'e')
            ->join('s.organisateur', 'o')
            ->join('s.users', 'u')
            ->select('s, e, o, u')
        ;


        if ($filtre->getCampus()) {
            $queryBuilder
                ->andWhere('s.campus = :newcampus')
                ->setParameter('newcampus', $filtre->getCampus());
        }

        if ($filtre->getCategorie()) {
            $queryBuilder
                ->andWhere('s.categorie = :newcat')
                ->setParameter('newcat', $filtre->getCategorie());
        }

        if ($filtre->getChampSaisie()) {
            $queryBuilder
                ->andWhere('s.nom LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$filtre->getChampSaisie().'%');
        }

        if ($filtre->getDateintervalmin()) {
            $queryBuilder
                ->andWhere('s.dateHeureDebut >= :datemin')
                ->setParameter('datemin', $filtre->getDateintervalmin());
        }

        if ($filtre->getDateintervalmax()) {
            $queryBuilder
                ->andWhere('s.dateHeureDebut <= :datemax')
                ->setParameter('datemax', $filtre->getDateintervalmax());
        }



            if($filtre -> isSortieInscrit()) {
                $queryBuilder
                    ->join('s.users', 'u')
                    ->andWhere('u = :currentuser')
                    ->setParameter('currentuser', $userId)
                ;
            }



            if($filtre -> isSortiePassee()) {
                $queryBuilder
                    ->andWhere('s.dateHeureDebut < :currentDate')
                    ->setParameter('currentDate', $today)
                ;
            }

            if($filtre -> isSortieOrga()) {
                $queryBuilder
                    ->andWhere('s.organisateur = :userorga')
                    ->setParameter('userorga', $user)
                ;
            }


            if($filtre -> isSortieNonInscrit()) {

                $queryBuilder
                    ->join('s.users', 'us')
                    ->andWhere('us != :currentuser')
                    ->andWhere('s.organisateur != :currentuser')
                    ->setParameter('currentuser', $userId)
                    ;
            }



        $queryBuilder
            ->orderBy('s.dateLimiteInscription', 'DESC')
            ->setMaxResults(20);
        $query = $queryBuilder->getQuery();

        return $query->getResult();

    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function findSortieWhoNeedsUpdate()
    {
        $today = new \DateTime();
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->andWhere('s.statut = 1')
            ->andWhere('s.dateLimiteInscription <= :today')
            ->setParameter('today', $today);
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function findSortieTerminee()
    {
        $today = new \DateTime();
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->andWhere('s.statut = 2')
            ->andWhere('s.dateHeureDebut < (:today + s.duree)')
            ->setParameter('today', $today);
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function findSortieEnCours()
    {
        $today = new \DateTime();
        $queryBuilder = $this->createQueryBuilder('s');
        $queryBuilder
            ->andWhere('s.dateHeureDebut = (:today + s.duree)')
            ->setParameter('today', $today);
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
}
