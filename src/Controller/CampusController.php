<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Repository\CampusRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampusController extends AbstractController
{
    #[Route('/campus', name: 'campus')]
    public function campuslist(CampusRepository $campusRepo, EntityManagerInterface $em): Response
    {
        $campus = $campusRepo->findAll();

        if (isset($_GET['nouveau-campus'])) {
            $nouveaucampus = $_GET['nom-nouveau-campus'];
            $camp = new Campus();
            $camp->setNom($nouveaucampus);
            $em->persist($camp);
            $em->flush();

            return $this->redirectToRoute('campus');
        }
        return $this->render('campus/campuslist.html.twig', [
            'controller_name' => 'CampusController',
            'campus' => $campus,
        ]);
    }

    /**
     * @Route("/campus/suppression/{id}", name="campus_supp", requirements={"id": "\d+"})
     */
    public function campussuppression($id, CampusRepository $campusRepo, UserRepository $userRepo): Response
    {
        $campus=$campusRepo->find($id);
        $users = $userRepo -> findAll();
        $usersDansCampus=0;
        $idCampus = $campus -> getId();

        foreach ($users as $user){
            $campusDuUser = $user -> getCampus();
            $idCampusUser = $campusDuUser -> getId();

            if($idCampusUser == $idCampus) {
                $usersDansCampus += 1;
            }
        }

        if(isset($_GET['suppression-campus-definitive'])){
                if($usersDansCampus == 0) {
                $campus = $campusRepo->deletecampus($id);
                $this->addFlash('success', 'Le campus a bien été supprimé');

                return $this->redirectToRoute('campus');
                }
                else {
                $this->addFlash('error', 'Vous ne pouvez pas supprimer ce campus car il y a des étudiants qui y sont inscrits...');
                }
            }


        return $this->render('campus/campusdelete.html.twig', [
            'campus' => $campus,
        ]);
    }

    /**
     * @Route("/campus/modification/{id}", name="campus_modif", requirements={"id": "\d+"})
     */
    public function campusmodification($id, CampusRepository $campusRepo, EntityManagerInterface $em): Response
    {
        $campus=$campusRepo->find($id);

        if(isset($_GET['modif-campus'])){
            $newname = $_GET['nom-campus'];
            $campus -> setNom($newname);
            $em -> persist($campus);
            $em ->flush();

            return $this->redirectToRoute('campus');
        }

        return $this->render('campus/campusmodify.html.twig', [
            'campus' => $campus,
        ]);
    }
}

