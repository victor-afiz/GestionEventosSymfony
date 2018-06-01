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
        $this->result = '';
        $email = $request->query->get('email');
        $password = $request->query->get('password');

        $repository = $this->getDoctrine()->getRepository(Usuario::class);
        $user = $repository->findOneBy(['email' => $email]);

        if (false === $user) {
            $this->result ='User not valid';
        }

        if ($user->getEmail() === $email && $user->getPassword() === $password){

          //  $this->result = 'Welcome ';
            $this->result =[$user->getName(), $user->getId()];
        }
        return new JsonResponse($this->result);
    }
}
