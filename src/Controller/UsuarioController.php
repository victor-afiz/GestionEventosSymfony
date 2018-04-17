<?php

namespace App\Controller;
header("Access-Control-Allow-Origin: *");


//use http\Env\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use  Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


use App\Entity\Usuario;

class UsuarioController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function news(Request $request)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $usuario = new Usuario();
        $usuario->setName($request->query->get('name'));
        $usuario->setSurname($request->query->get('lastName'));
        $usuario->setEmail($request->query->get('email'));
        $usuario->setPassword($request->query->get('password'));

        $entityManager->persist($usuario);

        $entityManager->flush();

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $user = $repository->findOneBy(['email' => $request->query->get('email')]);

        dump($user);
        return new JsonResponse([$user->getName(),$user->getId()]);

    }

}
