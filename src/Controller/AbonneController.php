<?php

namespace App\Controller;

use App\Entity\Abonne;
use App\Form\AbonneType;
use App\Repository\AbonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/abonne")
 */
class AbonneController extends AbstractController
{
    private $repository;

    public function __construct(AbonneRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="abonne", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('abonne/index.html.twig', [
            'abonnes' => $this->repository->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau", name="nouveau_abonne", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $abonne = new Abonne();
        $form = $this->createForm(AbonneType::class, $abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($abonne, true);

            return $this->redirectToRoute('abonne', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('abonne/new.html.twig', [
            'abonne' => $abonne,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="infos_abonne", methods={"GET"})
     * @param Abonne $abonne
     * @return Response
     */
    public function show(Abonne $abonne): Response
    {
        return $this->render('abonne/show.html.twig', [
            'abonne' => $abonne,
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier_abonne", methods={"GET", "POST"})
     * @param Request $request
     * @param Abonne $abonne
     * @return Response
     */
    public function edit(Request $request, Abonne $abonne): Response
    {
        $form = $this->createForm(AbonneType::class, $abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($abonne, true);

            return $this->redirectToRoute('abonne', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('abonne/edit.html.twig', [
            'abonne' => $abonne,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/supprimer{id}", name="supprimer_abonne", methods={"POST"})
     * @param Request $request
     * @param Abonne $abonne
     * @return Response
     */
    public function delete(Request $request, Abonne $abonne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonne->getId(), $request->request->get('_token'))) {
            $this->repository->remove($abonne, true);
        }

        return $this->redirectToRoute('abonne', [], Response::HTTP_SEE_OTHER);
    }
}
