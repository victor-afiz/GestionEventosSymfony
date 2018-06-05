<?php

namespace App\Controller;
header("Access-Control-Allow-Origin: *");
use App\Entity\Eventos;
use App\Entity\Pertenece;
use App\Entity\Usuario;
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
        $result = "";
        $adminID = $request->query->get('IdAdmin');
        $evetName = $request->query->get('nombre');
        $eventDescription = $request->query->get('descripcion');
        $eventUrl = $request->query->get('url');
        $eventTotalPrice = $request->query->get('totalPrice');
        $eventDate = $request->query->get('fecha');
        $eventAllMembers = $request->query->get('allUSer');


        if ($adminID && $evetName && $eventDescription && $eventUrl && $eventTotalPrice && $eventDate && $eventAllMembers){

        }else{

        }
            $evento = new Eventos();
            $evento->setIdAdmin($adminID);
            $evento->setNombreEvento($evetName);
            $evento->setDescrripcion($eventDescription);
            $evento->setEventImage($eventUrl);
            $evento->setTotalPrice($eventTotalPrice);
            $evento->setDate(\DateTime::createFromFormat('d/m/Y', $eventDate));

            $convertAllMembers = array_map('intval', explode(',', $eventAllMembers));



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
                    "Date" => $yourEvents->getDate(),
                    "Message" => $yourEvents->getMessage()
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
            if($Members){
                foreach ($Members as $member) {
                    $user = $entityManager->getRepository(Usuario::class)
                        ->findOneBy(['id' => $member->getIdUsuario(), 'deleteUser' => null]);
                    $arrayMembers[] = [

                        "id" => $member->getId(),
                        "idUsuario" => $member->getIdUsuario(),
                        "nombreParticipante" => $user->getName(),
                        "idEvento" => $member->getIdEvento(),
                        "mensaje" => $member->getMensaje(),
                        "deletParticipante" => $member->getDeletParticipante()

                    ];
                }

                $result = $arrayMembers;
            }else{
                $result ="Evento no encontrado";
            }

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
