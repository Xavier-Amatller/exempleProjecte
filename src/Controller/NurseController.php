<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

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


    #[Route('/nurses', name: 'app_nurse', methods: ['GET'])]
    public function findAll(): JsonResponse
    {
        return new JsonResponse(self::$data);
        //return $this->json($this->data);
    }

    #[Route('/nurse_login', name: 'app_home', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        return new JsonResponse(
            in_array(
                [
                    "nombre" => $request->get("nombre"),
                    "pwd" => $request->get("pwd")
                ],
                self::$data
            )
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
        return $this->json($nurseFind);
    }
}