<?php

namespace App\Controller;

use App\Entity\Massage;
use App\Form\MassageType;
use App\Repository\MassageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/massage")
 */
class MassageController extends AbstractController
{
    /**
     * @Route("/", name="massage_index", methods={"GET"})
     */
    public function index(MassageRepository $massageRepository): Response
    {
        return $this->render('massage/index.html.twig', [
            'massages' => $massageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="massage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $massage = new Massage();
        $form = $this->createForm(MassageType::class, $massage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($massage);
            $entityManager->flush();

            return $this->redirectToRoute('massage_index');
        }

        return $this->render('massage/new.html.twig', [
            'massage' => $massage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="massage_show", methods={"GET"})
     */
    public function show(Massage $massage): Response
    {
        return $this->render('massage/show.html.twig', [
            'massage' => $massage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="massage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Massage $massage): Response
    {
        $form = $this->createForm(MassageType::class, $massage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('massage_index', [
                'id' => $massage->getId(),
            ]);
        }

        return $this->render('massage/edit.html.twig', [
            'massage' => $massage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="massage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Massage $massage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$massage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($massage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('massage_index');
    }
}
