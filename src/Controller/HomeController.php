<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends BaseController
{
    #[Route('/', name: 'home.accueil')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'admin' => 'S4lazaar',
        ]);
    }
}
