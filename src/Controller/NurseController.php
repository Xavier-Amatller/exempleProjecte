<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}