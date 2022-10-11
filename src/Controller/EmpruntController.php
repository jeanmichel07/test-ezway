<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/emprunt")
 */
class EmpruntController extends AbstractController
{
    private $repository;

    public function __construct(EmpruntRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="emprunt", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $this->repository->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau", name="nouveau_emprunt", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($emprunt, true);

            return $this->redirectToRoute('emprunt', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emprunt/new.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/infos/{id}", name="infos_emprunt", methods={"GET"})
     * @param Emprunt $emprunt
     * @return Response
     */
    public function show(Emprunt $emprunt): Response
    {
        return $this->render('emprunt/show.html.twig', [
            'emprunt' => $emprunt,
        ]);
    }

    /**
     * @Route("/modifer/{id}/", name="modifier_emprunt", methods={"GET", "POST"})
     * @param Request $request
     * @param Emprunt $emprunt
     * @return Response
     */
    public function edit(Request $request, Emprunt $emprunt): Response
    {
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($emprunt, true);

            return $this->redirectToRoute('emprunt', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emprunt/edit.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer_emprunt", methods={"POST"})
     * @param Request $request
     * @param Emprunt $emprunt
     * @return Response
     */
    public function delete(Request $request, Emprunt $emprunt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emprunt->getId(), $request->request->get('_token'))) {
            $this->repository->remove($emprunt, true);
        }

        return $this->redirectToRoute('emprunt', [], Response::HTTP_SEE_OTHER);
    }
}
