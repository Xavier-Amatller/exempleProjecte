<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Nurse;
use Doctrine\ORM\EntityManagerInterface;

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


    #[Route('/list', name: 'app_nurse', methods: ['GET'])]
    public function findAll(): JsonResponse
    {
        return new JsonResponse($this->data, 200);
        //return $this->json($this->data);
    }

    #[Route('/login', name: 'app_nurse_login', methods: ['POST'])]
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
            $login_success,
            $login_success ? JsonResponse::HTTP_OK : JsonResponse::HTTP_UNAUTHORIZED
        );
    }

    #[Route('/search_by_name', name: 'app_search_by_name', methods: ['GET'])]
    public function searchNursesByName(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $name = $request->get('name') ?? null;
        $nursesFound = [];
        
        if (!is_null($name)) {
          $nursesFound = $entityManager->getRepository(className: Nurse::class)->
            findBy([
              "name" => $name
            ]);

          $nursesFound = array_map(
            callback: 
              fn($nurse): mixed=> [
                "name"=> $nurse->getName(),
                "surname" => $nurse->getSurname()
              ], 
            array: $nursesFound
          );
        }
        if (!empty($nursesFound)) 
            return new JsonResponse($nursesFound, 200);
        
        return new JsonResponse($nursesFound, 404);
    }
}