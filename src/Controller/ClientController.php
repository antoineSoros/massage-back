<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Company;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository): Response
    {
        $salons = $clientRepository->findBy(['profile'=>'fd1b3ed1-9f35-11e9-b353-a8a79509a70f']);
        $particuliers = $clientRepository->findBy(['profile'=>'02c9a9c2-9f36-11e9-b353-a8a79509a70f']);
        return $this->render("client/index.html.twig", [
            'clients' => $clientRepository->findAll(),
            'salons'=>$salons,
            'particuliers'=>$particuliers
        ]);
    }

    /**
     * @Route("/new", name="client_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
$message="";


        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $clients = $entityManager->getRepository(Client::class)->findBy(['mail'=>$client->getMail()]);
            if(empty($clients)){
            $entityManager->persist($client);

            $entityManager->flush();
            return $this->redirectToRoute('client_index');}
            else{
                $message = "Client existant";
                return $this->render('client/new.html.twig', [
                    'client' => $client,
                    'form' => $form->createView(),
                    'message'=>$message

                ]);

            }
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
            'message'=>null

        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index', [
                'id' => $client->getId(),
            ]);
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Client $client): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_index');
    }
}
