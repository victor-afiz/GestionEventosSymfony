<?php

namespace App\Controller;
header("Access-Control-Allow-Origin: *");


//use http\Env\Request;
use function MongoDB\BSON\toJSON;
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
     * @Route("/usuario", name="usuario")
     */
    /*
       public function index()
       {
           $entityManager = $this->getDoctrine()->getManager();

           $usuario = new Usuario();


           $entityManager->persist($usuario);

           $entityManager->flush();

           //return new Response('Saved new product with id '.$usuario->setId());



           $arr = array('nombre' => $usuario->getName(), 'apellido' => $usuario->getSurname());


           return new JsonResponse($arr);


       }
   */

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function news(Request $request)
    {

        dump( $request);
        //return new Response($request->query->get('name'));
        return new JsonResponse($request->query->get('name'));

    }

}
