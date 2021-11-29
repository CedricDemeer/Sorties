<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\FiltreSortieType;
use App\Form\LieuType;
use App\Form\SortieType;
use App\Modele\FiltreSortie;
use App\Repository\SortieRepository;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/sortie', name: 'sortie')]
    public function sortielist(SortieRepository $sortieRepo,
                               StatutRepository $statutRepo,
                               EntityManagerInterface $em,
                               Request $request,): Response
    {
/*
        $cnx=$em->getConnection();
        $sth=$cnx->prepare("call archiver()");
        $sth->execute();*/
        $sortie = new FiltreSortie();
        $user = $this->getUser();
        $filtreSortieForm = $this->createForm(FiltreSortieType::class, $sortie);
        $filtreSortieForm->handleRequest($request);

        $sortiesUpdate = $sortieRepo->findSortieWhoNeedsUpdate();
        $statut = $statutRepo -> find(2);

        foreach ($sortiesUpdate as $sortieUpdate) {
           $sortieUpdate ->setStatut($statut);
           $em->flush();
        }

        $sortiesTerminees = $sortieRepo->findSortieTerminee();
        $statut = $statutRepo -> find(5);

        foreach ($sortiesTerminees as $sortieTerminees) {
            $sortieTerminees ->setStatut($statut);
            $em->flush();
        }

        $sortiesEnCours = $sortieRepo->findSortieEnCours();
        $statut = $statutRepo -> find(7);

        foreach ($sortiesEnCours as $sortieEnCours) {
            $sortieEnCours ->setStatut($statut);
            $em->flush();
        }

        $sorties = $sortieRepo->findByFilter($sortie, $user);

        return $this->render('sortie/sortielist.html.twig', [
            "sorties" => $sorties,
            "filtreSortieForm" => $filtreSortieForm->createView()
        ]);
    }


    /**
     * @Route("/sortie/{id}", name="sortie_details", requirements={"id": "\d+"})
     */
    public function sortieDetail($id, SortieRepository $repo)
    {
        $sortie = $repo->find($id);

        if (empty($sortie)) {
            throw $this->createNotFoundException("Cette sortie n'existe pas encore !");
        }

        return $this->render("sortie/sortiedetails.html.twig", [
            "sortie" => $sortie
        ]);
    }

    #[Route('/sortie/ajout', name: 'sortie_ajout')]
    public function add(EntityManagerInterface $em,
                        Request $request,
                        StatutRepository $statutRepo)
    {
        //on créé une entité de sortie
        $sortie = new Sortie();

        $sortie->setOrganisateur($this->getUser());
        $statut = $statutRepo->find(1);
        $sortie->setStatut($statut);
        //on créé le formulaire
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $lieu = new Lieu();
        $lieuForm = $this->createForm(LieuType::class, $lieu);
        $lieuForm->handleRequest($request);

        //on récupère les informations du formulaire
        $sortieForm->handleRequest($request);

        if ($lieuForm->isSubmitted() && $lieuForm->isValid()) {
            $em->persist($lieu);
            $em->flush();
            $this->addFlash('success', 'Votre lieu a été ajouté');
        }

        //si le formulaire est bien soumis alors on rentre les informations en BDD
        if (isset($_POST['save']) && $sortieForm->isSubmitted() && $sortieForm->isValid()) {

                $statut = $statutRepo -> find('6');
                $sortie -> setStatut($statut);
                $em->persist($sortie);
                $em->flush();

                //ajout d'un message flash pour dire à l'utilisateur que sa sortie a été ajoutée
                $this->addFlash('success', 'Votre sortie a bien été ajoutée !');

                //redirection vers la page sortie_details de la sortie créée
                return $this->redirectToRoute('sortie_modification', [
                    'id' => $sortie->getId()
                ]);
            }

        if(isset($_POST['publication']) && $sortieForm->isSubmitted() && $sortieForm->isValid()) {
                $statut = $statutRepo -> find('1');
                $sortie -> setStatut($statut);
                $em->persist($sortie);
                $em->flush();

                //ajout d'un message flash pour dire à l'utilisateur que sa sortie a été ajoutée
                $this->addFlash('success', 'Votre sortie a bien été ajoutée !');

                //redirection vers la page sortie_details de la sortie créée
                return $this->redirectToRoute('sortie_details', [
                    'id' => $sortie->getId()
                ]);
            }


        return $this->render('sortie/sortieadd.html.twig', [
            "sortieForm" => $sortieForm->createView(),
            "lieuForm" => $lieuForm->createView()
        ]);

    }

    /**
     * @Route("/sortie/modification/{id}", name="sortie_modification", requirements={"id": "\d+"})
     */
    public function modify($id,
                           EntityManagerInterface $em,
                           Request $request,
                           StatutRepository $statutRepo,
                           SortieRepository $repo)
    {
        $user = new User();
        $user = ($this -> getUser());
        //on créé une entité de sortie
        $sortie = $repo ->find($id);
        //vérifier si l'objet retourné existe bien !!!


        $organisateur = $sortie -> getOrganisateur();

        // si l'organisateur est différent de l'utilisateur en cours alors
        // on redirige vers l'accueil

        //vérifier aussi le statut de la sortie > en statut créé uniquement
        if ($organisateur != $user) {
            return $this->redirectToRoute('accueil');
        }

        else {
            $sortieForm = $this->createForm(SortieType::class, $sortie);
            $sortieForm->handleRequest($request);
            //si le formulaire est bien soumis alors on rentre les informations en BDD
            if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
                if(isset($_POST['publication'])) {
                    $statut = $statutRepo ->find('1');
                    $sortie -> setStatut($statut);
                }
                $em->persist($sortie);
                $em->flush();

                //ajout d'un message flash pour dire à l'utilisateur que sa sortie a été ajoutée
                $this->addFlash('success', 'Votre sortie a bien été modifiée !');

                //redirection vers la page sortie_details de la sortie créée
                return $this->redirectToRoute('sortie_details', [
                    'id' => $sortie->getId()
                ]);
            }
        }
        return $this->render('sortie/sortiemodify.html.twig', [
            "sortieForm" => $sortieForm->createView(),
            "sortie" => $sortie,
        ]);

    }

    /**
     * @Route("/sortie/delete/{id}", name="sortie_suppression", requirements={"id": "\d+"})
     */
    public function delete($id,
                           EntityManagerInterface $em,
                           Request $request,
                           SortieRepository $repo,
                           StatutRepository $statutRepo)
    {
        $user = new User();
        $user = ($this -> getUser());
        //on créé une entité de sortie
        $sortie = $repo ->find($id);
        $organisateur = $sortie -> getOrganisateur();

        // si l'organisateur est différent de l'utilisateur en cours alors
        // on redirige vers l'accueil
        if ($organisateur != $user) {
            return $this->redirectToRoute('accueil');
        }
        else {
            if(isset($_POST['supprimer'])) {
                $raisonAnnulation = $request -> request -> get('textarea');
                $ancienneraison = $sortie -> getDescription();
                $ancientitre = $sortie -> getNom();
                $sortie -> setDescription($raisonAnnulation . " " . $ancienneraison);
                $sortie -> setNom('Annulée : '. $ancientitre);
                $statut = $statutRepo -> find(3);
                $sortie ->setStatut($statut);
                $em->flush();

                //ajout d'un message flash pour dire à l'utilisateur que sa sortie a été ajoutée
                $this->addFlash('success', 'Nous sommes désolés d\'apprendre que vous avez dû annuler votre sortie...');

                //redirection vers la page sortie_details de la sortie créée
                return $this->redirectToRoute('sortie_details', [
                    'id' => $sortie->getId()
                ]);
            }

        }

        return $this->render('sortie/sortiedelete.html.twig', [
            "sortie" => $sortie,
        ]);



    }

    /**
     * @Route("/sortie/sinscrie/{id}", name="sortie_sinscrire", requirements={"id": "\d+"})
     */
    public function sinscrire( $id,SortieRepository $repo,EntityManagerInterface $em){

        $sortie=$repo->find($id);
        //existe-t-elle bien ?

        //ai-je le droit de m'inscrire
        //date de clôture respectée
        //nbr de participant max atteint ?
        $sortie->addUser($this->getUser());
        $em->flush();
        return $this->redirectToRoute('sortie');
    }

    /**
     * @Route("/sortie/desinscrie/{id}", name="sortie_desinscrire", requirements={"id": "\d+"})
     */
    public function desinscrire ($id,SortieRepository $repo,EntityManagerInterface $em){

        $sortie= $repo->find($id);
        $sortie->removeUser($this->getUser());
        $em->flush();
        return $this->redirectToRoute('sortie');

    }
}
