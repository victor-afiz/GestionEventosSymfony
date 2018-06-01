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

    public function createEvent(Request $request)
    {
        $entityManager = $this->getDoctrine();

            //$user = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $request->query->get('email')]);

            $evento = new Eventos();
            $evento->setIdAdmin($request->query->get('IdAdmin'));
            $evento->setNombreEvento($request->query->get('nombre'));
            $evento->setDescrripcion($request->query->get('descripcion'));
            $evento->setEventImage($request->query->get('url'));
            $evento->setTotalPrice($request->query->get('totalPrice'));
            $evento->setDate(\DateTime::createFromFormat('d/m/Y', $request->get('fecha')));

            $entityManager->getManager()->persist($evento);
            $entityManager->getManager()->flush();

            $str = $request->query->get('allUSer');
            dump($request->query->get('allUSer'));
            $arr1 = explode(",",$str);


            $pertenece = new Pertenece();

            foreach ($arr1 as $kye){
//                print_r((int)$kye);
                $pertenece->setIdUsuario((int)$kye);
                $pertenece->setIdEvento($evento->getId());
                $entityManager->getManager()->persist($pertenece);
                $entityManager->getManager()->flush();
                $entityManager->getManager()->clear();
            }

            return new JsonResponse(['creado']);

    }

    public function getallEvent(Request $request)
    {
        $pertenece = $this->getDoctrine()
        ->getRepository(Pertenece::class)
        ->findBy(['id' => $request->query->get('id') , 'deletParticipante' => null]);
        dump($pertenece);
        die();

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
