<?php

namespace App\Controller;
header("Access-Control-Allow-Origin: *");


//use http\Env\Request;
use Doctrine\ORM\Query\ResultSetMapping;
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

        $entityManager = $this->getDoctrine();

        $user = $entityManager->getRepository(Usuario::class)->findOneBy(['email' => $request->query->get('email')]);

        if (!empty($user)){
            return new JsonResponse(['existe',$user->getName(),$user->getId()]);
        }else{

            $usuario = new Usuario();
            $usuario->setName($request->query->get('name'));
            $usuario->setNickname($request->query->get('nickName'));
            $usuario->setEmail($request->query->get('email'));
            $usuario->setPassword($request->query->get('password'));

            $entityManager->getManager()->persist($usuario);

            $entityManager->getManager()->flush();


            return new JsonResponse(['nuevo',$usuario->getName(),$usuario->getId()]);
        }

    }

    public function findUser(Request $request)
    {

        $entityManager = $this->getDoctrine();

        $user = $entityManager->getRepository(Usuario::class)
            ->findOneBy(['nickname'
                => $request->query
                    ->get('nickName')]);
        if($user){
            return new JsonResponse([$user->getId(),$user->getName(),$user->getNickname()]);
        }else{
            return new JsonResponse(["No Encontrado"]);
        }
    }

}
