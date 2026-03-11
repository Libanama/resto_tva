<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Form\AchatType;
use App\Repository\AchatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/achat')]
class AchatController extends AbstractController
{
    #[Route('/', name: 'app_achat_index', methods: ['GET'])]
    public function index(AchatRepository $achatRepository, Request $request): Response
    {
        $mois = $request->query->get('mois', date('m'));
        $annee = $request->query->get('annee', date('Y'));

        $achats = $achatRepository->findByMoisAnneeUser(
            (int)$mois,
            (int)$annee,
            $this->getUser()
        );

        return $this->render('achat/index.html.twig', [
            'achats' => $achats,
            'mois' => (int)$mois,
            'annee' => (int)$annee,
        ]);
    }

    #[Route('/new', name: 'app_achat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $achat = new Achat();
        $form = $this->createForm(AchatType::class, $achat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $achat->setUser($this->getUser());
            $em->persist($achat);
            $em->flush();
            $this->addFlash('success', 'Achat ajouté avec succès !');
            return $this->redirectToRoute('app_achat_index');
        }

        return $this->render('achat/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_achat_delete', methods: ['POST'])]
    public function delete(Request $request, Achat $achat, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$achat->getId(), $request->request->get('_token'))) {
            $em->remove($achat);
            $em->flush();
            $this->addFlash('success', 'Achat supprimé.');
        }

        return $this->redirectToRoute('app_achat_index');
    }
}