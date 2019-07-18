<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Company;
use App\Entity\Prestation;
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
//        $salons = $clientRepository->findBy(['profile'=>'99be0a06-a278-4c41-a774-7558a9c56499']);
        $salons = $clientRepository->findByProfile('SALON');
        $particuliers = $clientRepository->findByProfile('PARTICULIER');
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
            if(!empty($clients)){
                $message = "Client existant";
                return $this->render('client/new.html.twig', [
                    'client' => $client,
                    'form' => $form->createView(),
                    'message'=>$message

                ]);
           }


            else{
                $entityManager->persist($client);

                $entityManager->flush();
                if ($client->getProfile()!== null && $client->getProfile()->getName()==="SALON"){
                    return $this->redirectToRoute('company_new_owner',['ownerId' =>$client->getId()]);
                }
                return $this->redirectToRoute('client_index');


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
        $em = $this->getDoctrine()->getManager();
        $presta = $em->getRepository(Prestation::class)->findPrestationByClient($client);

        return $this->render('client/show.html.twig', [
            'client' => $client,
            'presta'=>$presta
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
