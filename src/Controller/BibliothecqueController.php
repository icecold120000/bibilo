<?php

namespace App\Controller;

use App\Entity\Bibliothecque;
use App\Form\BibliothecqueType;
use App\Repository\BibliothecqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bibliothecque")
 */
class BibliothecqueController extends AbstractController
{
    /**
     * @Route("/", name="bibliothecque_index", methods={"GET"})
     */
    public function index(BibliothecqueRepository $bibliothecqueRepository): Response
    {
        return $this->render('bibliothecque/index.html.twig', [
            'bibliothecques' => $bibliothecqueRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="bibliothecque_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bibliothecque = new Bibliothecque();
        $form = $this->createForm(BibliothecqueType::class, $bibliothecque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($bibliothecque);
            $entityManager->flush();

            $this->addFlash(
                'successBiblio',
                'Le bibliothèque a été sauvegardé !'
            );


            return $this->redirectToRoute('bibliothecque_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bibliothecque/new.html.twig', [
            'bibliothecque' => $bibliothecque,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="bibliothecque_detele_veiw", methods={"GET"})
     */
    public function delete_view(Bibliothecque $bibliothecque): Response
    {
        return $this->render('bibliothecque/delete_view.html.twig', [
            'bibliothecque' => $bibliothecque,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bibliothecque_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Bibliothecque $bibliothecque, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BibliothecqueType::class, $bibliothecque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'successBiblio',
                'Le bibliothèque a été modifié !'
            );

            return $this->redirectToRoute('bibliothecque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('bibliothecque/edit.html.twig', [
            'bibliothecque' => $bibliothecque,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="bibliothecque_delete", methods={"POST"})
     */
    public function delete(Request $request, Bibliothecque $bibliothecque, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bibliothecque->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bibliothecque);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bibliothecque_index', [], Response::HTTP_SEE_OTHER);
    }
}
