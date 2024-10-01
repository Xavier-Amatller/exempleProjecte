<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class NurseController extends AbstractController
{

    public static $data = [
        ["nombre" => "Xavier",
        "pwd" => "1234"],
        ["nombre" => "Hugo",
        "pwd" => "5555"],
        ["nombre" => "Glen",
        "pwd" => "0000"],
        ["nombre" => "Fernanfloo",
        "pwd" => "9876"]
    ];
    #[Route('/nurse_login', name: 'app_home', methods: ['GET'])]
    public function login(Request $request): JsonResponse
    {
      return new JsonResponse(in_array(
        ["nombre"=> $request->get("nombre"),
        "pwd"=>$request->get("pwd")],
        self::$data)
      );
    }
}