<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class NurseController extends AbstractController
{

    public $data = [
        [
            "nombre" => "Xavier",
            "apellido"=>"Amatller",
            "pwd" => "1234"
        ],
        [
            "nombre" => "Hugo",
            "apellido"=>"Gonzalez",
            "pwd" => "5555"
        ],
        [
            "nombre" => "Glen",
            "apellido"=>"Marti",
            "pwd" => "0000"
        ],
        [
            "nombre" => "Fernanfloo",
            "apellido"=>"Futbolista",
            "pwd" => "9876"
        ],
        [
            "nombre" => "Glen",
            "apellido"=>"Oliveres",
            "pwd" => "2323"
        ],
    ];

    #[Route('/searchByName', name: 'app_home', methods: ['POST'])]
    public function index(Request $request,): JsonResponse
    {
        $nurseFind = [];
        $name = $request->get('name') ?? null;
        if (is_null($name)) {
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
