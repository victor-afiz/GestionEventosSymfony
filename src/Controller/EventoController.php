<?php

namespace App\Controller;
header("Access-Control-Allow-Origin: *");
use App\Entity\Eventos;
use App\Entity\Pertenece;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;

class EventoController extends Controller
{

    public function index(Request $request)
    {
        $entityManager = $this->getDoctrine();

        //$user = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $request->query->get('email')]);

            $evento = new Eventos();
            $evento->setIdAdmin($request->get('admin'));
            $evento->setNombreEvento($request->get('nombre'));
            $evento->setDescrripcion($request->get('descripcion'));
            $evento->setEventImage($request->get('url'));
            //$evento->setDate(date("m-d-Y", strtotime($request->get('fecha'))));

            $entityManager->getManager()->persist($evento);

            $entityManager->getManager()->flush();

            $pertenece = new Pertenece();
            $pertenece->setIdUsuario($request->query->get('admin'));
            $pertenece->setIdEvento($evento->getId());


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
