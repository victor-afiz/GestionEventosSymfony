<?php

namespace App\Controller;
header("Access-Control-Allow-Origin: *");


//use http\Env\Request;
use albertcolom\Assert\AssertEmail;
use App\Entity\Pertenece;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use  Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


use App\Entity\Usuario;
use Webmozart\Assert\Assert;

class UsuarioController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function news(Request $request, \Swift_Mailer $mailer)
    {

        $entityManager = $this->getDoctrine();
        $name = $request->query->get('name');
        $nickName = $request->query->get('nickName');
        $email = $request->query->get('email');
        $password = $request->query->get('password');
        $result = "";


        if($name && $nickName && $email && $password){
                    $user = $entityManager->getRepository(Usuario::class)
            ->findOneBy(['email' => $request->query->get('email')]);

            $userNickname = $entityManager->getRepository(Usuario::class)
                ->findOneBy(['nickname' => $nickName]);
            if ($user){
                $result = ['existe',$user->getName(),$user->getId()];
            }else{
                if($userNickname){
                    $result = ["NickName introducido ya esta en uso"];
                }else{

                    if ($this->checkEmail($email)){
                        $PasswordHash =password_hash($password, PASSWORD_DEFAULT);

                        $usuario = new Usuario();
                        $usuario->setName($name);
                        $usuario->setNickname($nickName);
                        $usuario->setEmail($email);
                        $usuario->setPassword($PasswordHash);



                        $entityManager->getManager()->persist($usuario);

                        $entityManager->getManager()->flush();

                        $this->sendEmail($usuario->getName(),$usuario->getNickname(),$usuario->getEmail(),$usuario->getPassword(), $mailer);

                        $result = ['nuevo',$usuario->getName(),$usuario->getId()];
                    }else{
                        $result = ["Introduzca un correo electrónico válida"];
                    }
                }
            }
        }else{
            $result = ["Asegurate de que has rellenado todos los campos"];
        }
        return new JsonResponse($result);
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
            return new JsonResponse([]);
        }
    }

    public function getAll(Request $request)
    {
        $userID = $request->query->get('id');
        $entityManager = $this->getDoctrine();
        $result = "";


        if ($userID){
            $Users = $entityManager->getRepository(Usuario::class)
                ->findBy(['deleteUser' => null]);

            if($Users){

                $arrayUser = [];
                foreach ($Users as $user){
                    if ($user->getId() == $userID){

                    }else{

                        $arrayUser[] = [
                            "id" => $user->getId(),
                            "name" => $user->getName(),
                            "nick_name" => $user->getNickname(),
                            "email" => $user->getEmail(),
                            "password" => $user->getPassword()
                        ];
                    }

                }
                $result = $arrayUser;
            }else{
                $result = [];
            }
        }else{
            $result = [];
        }

        return new JsonResponse($result);
    }

    public function deleteUser(Request $request)
    {
        $result = "";
        $entityManager = $this->getDoctrine()->getEntityManager();
        $userID = $request->query->get('id');

        if($userID) {

            $user = $entityManager->getRepository(Usuario::class)->findOneBy(['id' => $userID, 'deleteUser' => null]);
            if($user === null){
                $result = "Usuario no encontrado";
            }else{

                $user->setDeleteUser(0);
                $entityManager->flush();

                $Members = $entityManager->getRepository(Pertenece::class)->findBy(['idUsuario' => $userID , 'deletParticipante' => null]);

                foreach ($Members as $member){

                    $member->setDeletParticipante(0);
                    $entityManager->flush();
                }

                $result = "Usuario eliminado";
            }
        }else{
            $result = "Usuario no encontrado";
        }

        return new JsonResponse($result);
   }

    public function sendEmail($Name,$Nickname,$Email,$Password, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo($Email)
            ->setBody(
                '<pre>'.
                '¡Te damos la bienvenida a WhatGram!'. $Name . 'Gracias por unirte a nuestra comunidad. Estos son los datos de tu cuenta:'.

                'Nombre: '. $Name .
                'NickName: '. $Nickname .
                'Email: '. $Email .
                'Password: '. $Password .

                'Enviado por WhatGram, Inc'.
                '</pre>'
            );

        $mailer->send($message);

        return "" ;
    }

    public function checkEmail($email) {
        if ( strpos($email, '@') !== false ) {
            $split = explode('@', $email);
            return (strpos($split['1'], '.') !== false ? true : false);
        }
        else {
            return false;
        }
    }

}
