<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use App\Repository\AchatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        RecetteRepository $recetteRepository,
        AchatRepository $achatRepository,
        Request $request
    ): Response {
        $mois = $request->query->get('mois', date('m'));
        $annee = $request->query->get('annee', date('Y'));

        $recettes = $recetteRepository->findByMoisAnneeUser((int)$mois, (int)$annee, $this->getUser());
        $achats = $achatRepository->findByMoisAnneeUser((int)$mois, (int)$annee, $this->getUser());

        // Calcul TVA collectée
        $tva55 = 0;
        $tva10 = 0;
        $tva20 = 0;
        $ca55 = 0;
        $ca10 = 0;
        $ca20 = 0;

        foreach ($recettes as $recette) {
            $t55 = (float)$recette->getTtc55();
            $t10 = (float)$recette->getTtc10();
            $t20 = (float)$recette->getTtc20();

            $ca55 += $t55;
            $ca10 += $t10;
            $ca20 += $t20;

            $tva55 += $t55 * (0.055 / 1.055);
            $tva10 += $t10 * (0.10 / 1.10);
            $tva20 += $t20 * (0.20 / 1.20);
        }

        $tvaColl = $tva55 + $tva10 + $tva20;
        $caTTC = $ca55 + $ca10 + $ca20;
        $caHT = $caTTC - $tvaColl;
        $totalPourboires = array_sum(array_map(fn($r) => (float)$r->getPourboire(), $recettes));

        // Calcul TVA déductible
        $tvaDed = array_sum(array_map(fn($a) => (float)$a->getTvaDeductible(), $achats));

        // TVA nette
        $tvaNet = $tvaColl - $tvaDed;

        $moisNoms = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        return $this->render('dashboard/index.html.twig', [
            'mois' => (int)$mois,
            'annee' => (int)$annee,
            'moisNom' => $moisNoms[(int)$mois],
            'moisNoms' => $moisNoms,
            'ca55' => $ca55,
            'ca10' => $ca10,
            'ca20' => $ca20,
            'caTTC' => $caTTC,
            'caHT' => $caHT,
            'tva55' => $tva55,
            'tva10' => $tva10,
            'tva20' => $tva20,
            'tvaColl' => $tvaColl,
            'tvaDed' => $tvaDed,
            'tvaNet' => $tvaNet,
            'totalPourboires' => $totalPourboires,
            'nbRecettes' => count($recettes),
            'nbAchats' => count($achats),
        ]);
    }
}