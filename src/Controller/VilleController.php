<?php

namespace App\Controller;


use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VilleRepository;
use App\Entity\Ville;
use Symfony\Component\Serializer\SerializerInterface;


class VilleController extends AbstractController
{
    #[Route('/ville', name: 'ville',methods: ['GET'])]

    public function villeList(VilleRepository $villeRepository): Response
    {
        $villes=$villeRepository->triVille();
        return $this->render('ville/villelist.html.twig', [
            'villes'=>$villes,
        ]);
    }

    #[Route("/ville2", name: 'ville2',methods: ['GET','POST'])]

    public function test(Request $request, VilleRepository $villerepo,SerializerInterface $serializer):JsonResponse{

            $nom=$request->getContent();
            $nom2=json_decode($nom);
            return new JsonResponse(

            $serializer->serialize($villerepo->rechercheVille($nom2),"json"),
                JsonResponse::HTTP_OK,
                [],
                true
            );


    }
}
