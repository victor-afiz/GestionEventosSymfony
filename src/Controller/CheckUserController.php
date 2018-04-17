<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CheckUserController extends Controller
{

    public function index()
    {
        return $this->render('check_user/index.html.twig', [
            'controller_name' => 'CheckUserController',
        ]);
    }
}
