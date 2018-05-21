<?php

namespace App\Controller;
header("Access-Control-Allow-Origin: *");
use App\Entity\Eventos;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventoController extends Controller
{

    public function index(Request $request)
    {
        $entityManager = $this->getDoctrine();

        //$user = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $request->query->get('email')]);


            $evento = new Eventos();
            $evento->setIdAdmin($request->query->get('admin'));
            $evento->setNombreEvento($request->query->get('nombre'));
            $evento->getDescrripcion($request->query->get('descripcion'));
        $evento->getEventImage($request->query->get('url'));
            $evento->setDate($request->query->get('fecha'));

            $entityManager->getManager()->persist($evento);

            $entityManager->getManager()->flush();

            return new JsonResponse(['creado']);

    }

    public function allEventos(Request $request)
    {
        $Events = $this->getDoctrine()
        ->getRepository(Eventos::class)
        ->findAll();
        //dump($Events);

        $arrayManagers = [];
        foreach ($Events as $Event){
            $arrayManagers[] = [
                "ID" => $Event->getId(),
                "AdminID" => $Event->getIdAdmin(),
                "Name" => $Event->getNombreEvento(),
                "Description" => $Event->getDescrripcion(),
                "Url" => $Event->getEventImage(),
                "Date" => $Event->getDate()
            ];
        }

        return new JsonResponse($arrayManagers);

    }
}
