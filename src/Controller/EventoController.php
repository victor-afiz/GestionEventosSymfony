<?php

namespace App\Controller;

use App\Entity\Eventos;
use Symfony\Component\HttpFoundation\Request;
use http\Env\Response;
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
            $evento->setDate($request->query->get('fecha'));

            $entityManager->getManager()->persist($evento);

            $entityManager->getManager()->flush();


            return new JsonResponse(['creado']);

    }
}
