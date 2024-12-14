<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\BienRepository;
use App\Service\JWTService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProprietaireController extends BaseController
{

    private $bienRepository;
    private $locationRepository;

    public function __construct(BienRepository $bienRepository,LocationRepository $locationRepository)
    {
        $this->bienRepository = $bienRepository;
        $this->locationRepository = $locationRepository;
    }

    #[Route('/proprietaire/login/{telephone}', name: 'proprietaire.login', methods: ['GET'])]
    public function login(string $telephone,UtilisateurRepository $utilisateurRepository,JWTService $jwtService): JsonResponse {
        try {
            $personne = $utilisateurRepository->loginProprietaire($telephone);
    
            if ($personne) {
                $payload = [
                    'id' => $personne->getId(),
                ];
                $token = $jwtService->generateToken($payload);
                $data = [
                    "utilisateur" => $personne,
                    "token" => $token,
                ];
    
                return $this->jsonResponse('success', $data, null, null);
            } else {
                return $this->jsonResponse('error', null, "Propriétaire non défini sur Mada-Immo", null);
            }
        } catch (\Exception $e) {
            return $this->jsonResponse('error', null, $e->getMessage(), null);
        }
    }

    #[Route('/api/biens', name: 'get_biens', methods: ['GET'])]
    public function getBiens()
    {
        $biens = $this->bienRepository->findAllBiensWithDetails();

        return new JsonResponse($biens);
    }

    #[Route('/api/totalCA', name: 'get_total_chiffre_affaires', methods: ['GET'])]
    public function getChiffreAffaires(Request $request)
    {
        $dateDebut = new \DateTimeImmutable($request->query->get('date_debut', '2024-01-01'));
        $dateFin = new \DateTimeImmutable($request->query->get('date_fin', '2025-12-31'));

        $chiffreAffairesTotal = $this->locationRepository->calculerChiffreAffairesTotal($dateDebut, $dateFin);

        // Retourner la réponse JSON
        return new JsonResponse([
            'chiffre_affaires_total' => $chiffreAffairesTotal
        ]);
    }
}

