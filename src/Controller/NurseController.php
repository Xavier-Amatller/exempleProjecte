<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/nurse')]
class NurseController extends AbstractController
{


    public $data = [
        [
            "nombre" => "Xavier",
            "apellido" => "Amatller",
            "pwd" => "1234"
        ],
        [
            "nombre" => "Hugo",
            "apellido" => "Gonzalez",
            "pwd" => "5555"
        ],
        [
            "nombre" => "Glen",
            "apellido" => "Marti",
            "pwd" => "0000"
        ],
        [
            "nombre" => "Fernanfloo",
            "apellido" => "Futbolista",
            "pwd" => "9876"
        ],
        [
            "nombre" => "Glen",
            "apellido" => "Oliveres",
            "pwd" => "2323"
        ],
    ];


    #[Route('/list', name: 'app_nurse')]
    public function findall(): JsonResponse
    {
        return new JsonResponse(self::$data,200);
        //return $this->json($this->data);
    }

    #[Route('/login', name: 'app_home', methods: ['GET'])]
    public function login(Request $request): JsonResponse
    {
      $login_success = in_array(
        [
            "nombre" => $request->get("nombre"),
            "apellido" => $request->get("apellido"),
            "pwd" => $request->get("pwd")
        ],
        $this->data
      );
        // Returns HTTP code status 200 if login is correct, 401 otherwise.
        return new JsonResponse(
            $login_success, $login_success?JsonResponse::HTTP_OK : JsonResponse::HTTP_UNAUTHORIZED
        );
    }

    #[Route('/searchByName', name: 'app_home', methods: ['GET'])]
    public function searchNursesByName(Request $request): JsonResponse
    {
        $nurseFind = [];
        $name = $request->get('name') ?? null;
        if (!is_null($name)) {
            foreach ($this->data as $key => $value) {
                if ($value["nombre"] == (string)$name) {
                    array_push($nurseFind, [
                        'Nombre' => $value['nombre'],
                        'Apellido' => $value['apellido'],
                    ]);
                }
            }
        }
        return $this->json($nurseFind,200);
    }
}