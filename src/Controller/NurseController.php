<?php

namespace App\Controller;

use App\Entity\Nurse;
use App\Repository\NurseRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Json;

#[Route('/nurse')]
class NurseController extends AbstractController
{

    #[Route('/list', name: 'app_nurse', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager): JsonResponse
    {
        $nurses = $entityManager->getRepository(Nurse::class)->findAll();
        $data = [];
        foreach ($nurses as $nurse) {
            array_push(
                $data,
                $nurse->getId(),
                $nurse->getName(),
                $nurse->getSurname(),
                $nurse->getEmail(),
                $nurse->getPasswd(),
            );
        }
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

    #[Route('/login', name: 'app_nurse_login', methods: ['POST'])]
    public function login(Request $request, EntityManagerInterface $entityManagerInterface): JsonResponse
    {

        $findBy  = [
            "email" => $request->get("email"),
            "passwd" => $request->get("passwd")
        ];

        $nurse = $entityManagerInterface->getRepository(Nurse::class)->findOneBy(
            $findBy
        );

        $login_success = isset($nurse)
            ? true
            : false;

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
            $nursesFound = $entityManager->getRepository(className: Nurse::class)->findBy([
                    "name" => $name
                ]);

            $nursesFound = array_map(
                callback: fn($nurse): mixed => [
                    "name" => $nurse->getName(),
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
