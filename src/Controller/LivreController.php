<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    private $repository;

    public function __construct(LivreRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="livre", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('livre/index.html.twig', [
            'livres' => $this->repository->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau", name="nouveau_livre", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($livre, true);

            return $this->redirectToRoute('livre', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/infos/{id}", name="infos_livre", methods={"GET"})
     * @param Livre $livre
     * @return Response
     */
    public function show(Livre $livre): Response
    {
        return $this->render('livre/show.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/modifier/{id}/", name="modifier_livre", methods={"GET", "POST"})
     * @param Request $request
     * @param Livre $livre
     * @return Response
     */
    public function edit(Request $request, Livre $livre): Response
    {
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->add($livre, true);

            return $this->redirectToRoute('livre', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer_livre", methods={"POST"})
     * @param Request $request
     * @param Livre $livre
     * @return Response
     */
    public function delete(Request $request, Livre $livre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $this->repository->remove($livre, true);
        }

        return $this->redirectToRoute('livre', [], Response::HTTP_SEE_OTHER);
    }
}
