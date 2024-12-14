<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UtilisateurRepository;
use App\Repository\LocationRepository;
use App\Service\JWTService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends BaseController
{
    #[Route('/client', name: 'app_client')]
    public function index(): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }

    #[Route('/client/login/{email}', name: 'client.login', methods: ['GET'])]
    public function login(string $email, UtilisateurRepository $utilisateurRepository, JWTService $jwtService): JsonResponse
    {
        try {
            $client = $utilisateurRepository->loginClient($email);

            if ($client) {
                $payload = [
                    'id' => $client->getId(),
                ];
                $token = $jwtService->generateToken($payload);
                $data = [
                    "utilisateur" => $client,
                    "token" => $token,
                ];

                return $this->jsonResponse('success', $data, null, null);
            } else {
                return $this->jsonResponse('error', null, "Client non défini sur Mada-Immo", null);
            }
        } catch (\Exception $e) {
            return $this->jsonResponse('error', null, $e->getMessage(), null);
        }

        // Ajouter les en-têtes CORS
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;

    }


    #[Route('/api/locations-loyer', methods: ['GET'])]
    public function getLoyers(LocationRepository $locationRepository, Request $request): JsonResponse
    {
        $dateDebut = $request->query->get('date_debut');
        $dateFin = $request->query->get('date_fin');

        if (!$dateDebut || !$dateFin) {
            return $this->json(['error' => 'Dates manquantes'], 400);
        }

        try {
            $dateDebut = new \DateTimeImmutable($dateDebut);
            $dateFin = new \DateTimeImmutable($dateFin);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Format de date invalide'], 400);
        }

        $locations = $locationRepository->findLocationsBetweenDates($dateDebut, $dateFin);

        $response = [];
        foreach ($locations as $location) {
            $response[] = [
                'id_location' => $location->getId(),
                'client_nom' => $location->getClient()->getNom(),
                'client_prenom' => $location->getClient()->getPrenom(),
                'bien_nom' => $location->getBien()->getNom(),
                'duree' => $location->getDuree(),
                'date_debut' => $location->getDateDebut()->format('Y-m-d'),
                'montant_total' => $location->getMontantTotal()
            ];
        }

        return $this->json($response);
    }

    
}


