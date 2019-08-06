<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @Route("/client")
 */
class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client_index", methods={"GET"})
     */
    public function index(ClientRepository $clientRepository, PhotoRepository $photoRepository): Response
    {
        $clients = $clientRepository->findAll();
        foreach ($clients as $client) {
            $client->setPhotoUrl($photoRepository->findUrl($client));
            $client->setPhotoThumbnailUrl($photoRepository->findThumbnailUrl($client));
        }
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
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

        if ($form->isSubmitted() && $form->isValid()) {
            //$filename = $client->getPhoto();
            $filedata = $form->get('photo')->getData();
            $filename = '';
            if (!empty($filedata)) {
                $filename = $filedata->getPathname();
            }
            if (file_exists($filename) and is_uploaded_file($filename)) {
                $fileContents = \file_get_contents($filename);
                $client->setPhoto($fileContents);
                $saveDate = new \DateTime();
                $client->setPhotoSaveDate($saveDate);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_index');
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client, PhotoRepository $photoRepository): Response
    {
        $client->setPhotoUrl($photoRepository->findUrl($client));
        $client->setPhotoThumbnailUrl($photoRepository->findThumbnailUrl($client));

        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Client $client, PhotoRepository $photoRepository): Response
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$filename = $client->getPhoto();
            $filedata = $form->get('photo')->getData();
            $filename = '';
            if (!empty($filedata)) {
                $filename = $filedata->getPathname();
            }
            if (file_exists($filename) and is_uploaded_file($filename)) {
                $fileContents = \file_get_contents($filename);
                $client->setPhoto($fileContents);
                $saveDate = new \DateTime();
                $client->setPhotoSaveDate($saveDate);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client_index');
        }

        $client->setPhotoUrl($photoRepository->findUrl($client));
        $client->setPhotoThumbnailUrl($photoRepository->findThumbnailUrl($client));

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
