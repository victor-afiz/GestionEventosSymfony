<?php

namespace App\Controller;
header("Access-Control-Allow-Origin: *");
use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckUserController extends Controller
{
    private $result;
    public function login(Request $request)
    {

        $result = '';
        $email = $request->query->get('email');
        $password = $request->query->get('password');

        if ($email && $password){

            $repository = $this->getDoctrine()->getRepository(Usuario::class);
            $user = $repository->findOneBy(['email' => $email]);

            if (false === $user) {
                $result ='User not valid';
            }else{

                $userEmail = $user->getEmail();
                $userPassword = $user->getPassword();
                $checkPassword = password_verify ( $password, $userPassword);

                if($checkPassword && $userEmail === $email){
                    $result =[$user->getName(), $user->getId()];
                }
            }

        }

        return new JsonResponse($result);

    }
}
