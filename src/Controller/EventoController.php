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

            $allMembers = $request->query->get('allUSer');
            $convertAllMembers = array_map('intval', explode(',', $allMembers));



            $evento->setTotalMemebers(count($convertAllMembers)+1);
            $entityManager->getManager()->persist($evento);
            $entityManager->getManager()->flush();

            $pertenece = new Pertenece();

                $pertenece->setIdUsuario($evento->getIdAdmin());
                $pertenece->setIdEvento($evento->getId());
                $entityManager->getManager()->persist($pertenece);
                $entityManager->getManager()->flush();
                $entityManager->getManager()->clear();

            foreach ($convertAllMembers as $kye){

                $pertenece->setIdUsuario($kye);
                $pertenece->setIdEvento($evento->getId());
                $entityManager->getManager()->persist($pertenece);
                $entityManager->getManager()->flush();
                $entityManager->getManager()->clear();

            }

            return new JsonResponse(['creado']);

    }

    public function getallEvent(Request $request)
    {
        $entityManager = $this->getDoctrine();

        $Members = $entityManager->getRepository(Pertenece::class)
            ->findBy(['idUsuario' => $request->query->get('id') , 'deletParticipante' => null]);


        foreach ($Members as $member){
            $EventsId[] = [
                'idEvento' => $member->getIdEvento()
            ];
        }

        foreach ($EventsId as $eventid){

            $allYourEvents = $entityManager->getRepository(Eventos::class)
                ->findBy(['id' => $eventid['idEvento'] , 'deleteEvent' => null]);

            foreach ($allYourEvents as $yourEvents) {
                $arrayManagers[] = [
                    "ID" => $yourEvents->getId(),
                    "AdminID" => $yourEvents->getIdAdmin(),
                    "Name" => $yourEvents->getNombreEvento(),
                    "Description" => $yourEvents->getDescrripcion(),
                    "Url" => $yourEvents->getEventImage(),
                    "TotalMemebers" => $yourEvents->getTotalMemebers(),
                    "Date" => $yourEvents->getDate()
                ];
            }
        }
        return new JsonResponse($arrayManagers);
    }

    function getAllMembers(Request $request)
    {
        $entityManager = $this->getDoctrine();

        $result = "";

        if($request->query->get('id')){
            $Members = $entityManager->getRepository(Pertenece::class)
                ->findBy(['idEvento' => $request->query->get('id') , 'deletParticipante' => null]);

            foreach ($Members as $member) {
                $arrayMembers[] = [

                    "id" => $member->getId(),
                    "idUsuario" => $member->getIdUsuario(),
                    "idEvento" => $member->getIdEvento(),
                    "mensaje" => $member->getMensaje(),
                    "deletParticipante" => $member->getDeletParticipante()

                ];
            }
            $result = $arrayMembers;
        }else{

            $result = "Evento no encontrado" ;
        }


        return new JsonResponse($result);
    }

    public function deleteEvent(Request $request)
    {
        $result = "";

        if($request->query->get('id')){
            $em = $this
                ->getDoctrine()
                ->getEntityManager();
            $event = $em
                ->getRepository(Eventos::class)
                ->findOneBy(['id' => $request->query->get('id') , 'deleteEvent' => null]);

            if($event === null){
                $result = "Evento no encontrado";
            }else{
                $event->setDeleteEvent(0);
                $em->flush();
                $result = "Eliminado";
            }

        }else{
            $result = "Evento no encontrado";
        }


        return new JsonResponse($result);
    }

    public function deleteMember(Request $request)
    {
        $result = "";

        if($request->query->get('idusuario') && $request->query->get('idEvento')){

            $em = $this->getDoctrine()->getEntityManager();

            $event = $em
                ->getRepository(Pertenece::class)
                ->findOneBy(['idUsuario' => $request->query->get('idusuario') ,'idEvento' => $request->query->get('idEvento'), 'deletParticipante' => null]);
            dump($request->query->get('idusuario'));
            dump($request->query->get('idEvento'));

            dump($event);
            die;

//            if($event === null){
//                $result = "Evento no encontrado";
//            }else{
//                $event->setDeleteEvent(0);
//                $em->flush();
//                $result = "Eliminado";
//            }
//
        }else{
        }

//        if($request->query->get('idUser') && $request->query->get('idEvent')){
//            $em = $this->getDoctrine()->getEntityManager();
//
//            $event = $em
//                ->getRepository(Pertenece::class)
//                ->findOneBy(['idUser' => $request->query->get('id') ,'idEvent' => $request->query->get('id') 'deleteEvent' => null]);
//
//            if($event === null){
//                $result = "Evento no encontrado";
//            }else{
//                $event->setDeleteEvent(0);
//                $em->flush();
//                $result = "Eliminado";
//            }
//
//        }else{
//            $result = "Evento no encontrado";
//        }
        return new JsonResponse("");
    }

}
