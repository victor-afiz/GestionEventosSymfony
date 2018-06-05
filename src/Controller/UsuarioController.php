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
    public function news(Request $request, \Swift_Mailer $mailer)
    {

        $entityManager = $this->getDoctrine();


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

            $this->sendNudes($usuario->getName(),$usuario->getNickname(),$usuario->getEmail(),$usuario->getPassword(), $mailer);

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

    public function getAll(Request $request)
    {
        $entityManager = $this->getDoctrine();

        $Users =  $entityManager
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('usuario')
            ->from('App:Usuario', 'usuario')
            ->where('usuario.id != :id')
            ->setParameter('id', $request->query->get('id'))
            ->getQuery()
            ->execute();

        $arrayUser = [];
        foreach ($Users as $user){
            $arrayUser[] = [
                "id" => $user->getId(),
                "name" => $user->getName(),
                "nick_name" => $user->getNickname(),
                "email" => $user->getEmail(),
                "password" => $user->getPassword()
            ];
        }
        return new JsonResponse($arrayUser);
    }

    public function deleteUser(Request $request)
    {
        $result = "";

        if($request->query->get('id')) {
            $em = $this->getDoctrine()->getEntityManager();
            $user = $em->getRepository(Usuario::class)->findOneBy(['id' => $request->query->get('id'), 'deleteUser' => null]);
            if($user === null){
                $result = "Usuario no encontrado";
            }else{

                $user->setDeleteUser(0);
                $em->flush();

                $result = "Usuario eliminado";
            }

        }else{
            $result = "Usuario no encontrado";
        }

        return new JsonResponse($result);
   }

    public function sendNudes($Name,$Nickname,$Email,$Password, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('afeez@mailinator.com')
            ->setBody(
                '<pre>'.
                '¡Te damos la bienvenida a WhatGram!'. $Name. 'Gracias por unirte a nuestra comunidad. Estos son los datos de tu cuenta:'.

                'Nombre: '. $Name.
                'NickName: '. $Nickname.
                'Email: '. $Email.
                'Password: '. $Password .

                'Enviado por WhatGram, Inc'.
                '</pre>'
            );

        $mailer->send($message);

        return "" ;
    }

}
