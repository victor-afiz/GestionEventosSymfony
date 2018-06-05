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
        $entityManager = $this->getDoctrine()->getEntityManager();
        $EventID = $request->query->get('idEvent');

        if($EventID){
            $entityManager = $this
                ->getDoctrine()
                ->getEntityManager();

            $event = $entityManager
                ->getRepository(Eventos::class)
                ->findOneBy(['id' => $request->query->get('idEvent') , 'deleteEvent' => null]);

            if($event === null){
                $result = "Evento no encontrado";
            }else{
                $event->setDeleteEvent("");
                $entityManager->flush();

                $members = $entityManager
                    ->getRepository(Pertenece::class)
                    ->findBy(['idEvento' => $request->query->get('idEvent') , 'deletParticipante' => null]);

                if ($members){

                    foreach ($members as $member){

                        $user = $entityManager
                            ->getRepository(Pertenece::class)
                            ->findOneBy(['id' => $member->getId(), 'deletParticipante' => null]);

                        $user->setDeletParticipante(0);
                        $entityManager->flush();
                    }
                    $result = "Evento y Participantes Eliminados";
                }

            }

        }else{
            $result = "Evento no encontrado";
        }


        return new JsonResponse($result);
    }

    public function deleteMember(Request $request)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        $result = "";
        $userID = $request->query->get('idUser');
        $eventID = $request->query->get('idEvent');

        if($userID && $eventID)
        {
            $user = $entityManager
                ->getRepository(Pertenece::class)
                ->findOneBy(['idUsuario' => $userID, 'idEvento' => $eventID, 'deletParticipante' => null]);
            if($user === null)
            {
                $result = "Participante no encontrado";
            }else{

                $user->setDeletParticipante(0);
                $entityManager->flush();

                $result = "Participante Eliminado";
            }

        }else{
            $result = "Participante no encontrado";
        }

        return new JsonResponse($result);
    }

    public function setMemberMessage(Request $request)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        $result = "";
        $userID = $request->query->get('idUser');
        $eventID = $request->query->get('idEvent');
        $messege = $request->query->get('message');

        if($userID && $eventID && $messege) {

            $user = $entityManager->getRepository(Pertenece::class)
                ->findOneBy(['idUsuario' => $userID,'idEvento' => $eventID,'idEvento' => $eventID, 'deletParticipante' => null]);
            if($user === null){
                $result = "Participante no encontrado";
            }else{

                $user->setMensaje($messege);
                $entityManager->flush();

                $result = "Mensaje Modificado";
            }

        }else{
            $result = "Participante no encontrado";
        }
        return new JsonResponse($result);
    }

    public function setEventMessage(Request $request)
    {
        $entityManager = $this->getDoctrine()->getEntityManager();
        $result = "";
        $eventID = $request->query->get('idEvent');
        $messege = $request->query->get('message');

        if( $eventID && $messege) {

            $user = $entityManager->getRepository(Eventos::class)
                ->findOneBy(['id' => $eventID, 'deleteEvent' => null]);

            if($user === null){
                $result = "Evento no encontrado";
            }else{

                $user->setMessage($messege);
                $entityManager->flush();

                $result = "Mensaje Modificado";
            }

        }else{
            $result = "Evento no encontrado";
        }
        return new JsonResponse($result);
    }



}
