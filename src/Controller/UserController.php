<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUserType;
use App\Form\PhotoType;
use App\Form\UserType;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/user/monprofil', name: 'user_monprofil')]

    public function afficherProfil(EntityManagerInterface $em, Request $request): Response
    {
        $user = new User();

        $user = ($this->getUser());
        $PhotoOK = false;

         //redirection si pas user
        if(!$user)
        {
            return $this->redirectToRoute('accueil');
        }
        if($user->getPhoto())
        {
            $PhotoOK = true;
        }
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid())
        {
             $em->persist($user);
             $em->flush();
             //dump($user);

             $this->addFlash("success", "Votre profil a été modifié");

        }
        //ajout du refresh pour enlever le pbl de modif du user en cours d'utilisation
        $em ->refresh($user);
        return $this->render('user/MonProfil.html.twig',
            ["Formulaire" => $userForm->createView(),
                "PhotoOK" => $PhotoOK
            ]);
    }


    /**
     * @Route("/user/{id}",name="user_profil", requirements={"id": "\d+"})
     */

    public function afficherIDProfil($id, EntityManagerInterface $em): Response
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        return $this->render('user/profil.html.twig', [
            "user" => $userRepo->find($id)
        ]);
    }


    #[Route('/admin/newuser', name: 'admin_create_user')]
    public function createUser(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $userFormulaire = $this->createForm(AdminUserType::class, $user);


        $userFormulaire->handleRequest($request);
        if($userFormulaire->isSubmitted() && $userFormulaire->isValid())
        {
            $user->setPhotoFile(new \Symfony\Component\HttpFoundation\File\File('uploads/images/profils/profil-vide.png'));

            // Encode the plain password, and set it.
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $userFormulaire->get('password')->getData()
            );
            $user->setPassword($encodedPassword);
            /*if($userFormulaire->get('administrateur')->getData())
                {
                    $user->setRoles(['ROLE_ADMIN']);
                }else{
                    $user->setRoles(['ROLE_USER']);
                }*/
            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "L'utilisateur a été crée");

            return $this->redirectToRoute('admin_list_user');

        }



        return $this->render('admin/user/create.html.twig',
        [
            "Formulaire" => $userFormulaire->createView()
        ]);
    }

    #[Route('/admin/users', name: 'admin_list_user')]
    public function list() : Response
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $users = $userRepo->findAll();

        return $this->render('admin/user/user_list.html.twig', [
            "users" => $users
        ]);
    }

    #[Route("/admin/setadmin/{id}", name: 'setadmin',methods: ['GET','POST'])]

    public function test(Request $request, SerializerInterface $serializer, $id): JsonResponse{

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $userbdd = $userRepo->find($id);
        $admin = $userbdd->getAdministrateur();

        return new JsonResponse(

            $serializer->serialize($admin->getAdministrateur(),"json"),
            JsonResponse::HTTP_OK,
            [],
            true
        );


    }



}
