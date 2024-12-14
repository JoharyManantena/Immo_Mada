<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UtilisateurRepository;
use App\Repository\LocationRepository;
use App\Service\JWTService;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends BaseController
{

    private LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }
    
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/login/{pseudo}/{mdp}', name: 'admin.login', methods: ['GET'])]
    public function login(string $pseudo, string $mdp, UtilisateurRepository $utilisateurRepository, JWTService $jwtService): JsonResponse
    {
        try {
            $admin = $utilisateurRepository->loginAdmin($pseudo, $mdp);

            if ($admin) {
                $payload = [
                    'id' => $admin->getId(),
                ];
                $token = $jwtService->generateToken($payload);
                $data = [
                    "utilisateur" => $admin,
                    "token" => $token,
                ];

                return $this->jsonResponse('success', $data, null, null);
            } else {
                return $this->jsonResponse('error', null, "Admin non défini sur Mada-Immo", null);
            }
        } catch (\Exception $e) {
            return $this->jsonResponse('error', null, $e->getMessage(), null);
        }
    }


    #[Route('/api/revenue', name: 'api_revenue', methods: ['GET'])]
    public function calculateMonthlyRevenue(): Response
    {
        $monthlyRevenue = $this->locationRepository->calculateMonthlyRevenue();
        return $this->json($monthlyRevenue);
    }

}
