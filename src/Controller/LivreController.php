<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/livre")
 */
class LivreController extends AbstractController
{
    /**
     * @Route("/", name="livre_index", methods={"GET"})
     */
    public function index(LivreRepository $livreRepository): Response
    {
        return $this->render('livre/index.html.twig', [
            'livres' => $livreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="livre_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,
                        SluggerInterface $slugger): Response
    {
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre,
            array('row_attr' => array('route' =>$request->get('_route'))));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $fichierDocument */
            $fichierDocument = $form->get('afficheLivre')->getData();

            if ($fichierDocument) {
                $originalFilename = pathinfo($fichierDocument
                    ->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$fichierDocument->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $fichierDocument->move(
                        $this->getParameter('affiche_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new FileException("Fichier corrompu.
                     Veuillez retransférer votre fichier !");
                }

                $livre->setAfficheLivre($newFilename);
            }

            $entityManager->persist($livre);
            $entityManager->flush();

            return $this->redirectToRoute('livre_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/new.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="livre_delete_view", methods={"GET"})
     */
    public function delete_view(Livre $livre): Response
    {
        return $this->render('livre/delete_view.html.twig', [
            'livre' => $livre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="livre_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Livre $livre, EntityManagerInterface $entityManager,
                         SluggerInterface $slugger): Response
    {
        $form = $this->createForm(LivreType::class, $livre,
            array('row_attr' => array('route' =>$request->get('_route'))));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $fichierDocument */
            $fichierDocument = $form->get('afficheLivre')->getData();

            if ($fichierDocument) {
                $originalFilename = pathinfo($fichierDocument
                    ->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$fichierDocument->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $fichierDocument->move(
                        $this->getParameter('affiche_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new FileException("Fichier corrompu.
                     Veuillez retransférer votre fichier !");
                }

                $livre->setAfficheLivre($newFilename);
            }
            $entityManager->flush();

            return $this->redirectToRoute('livre_edit', ['id' => $livre->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livre/edit.html.twig', [
            'livre' => $livre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="livre_delete", methods={"POST"})
     */
    public function delete(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($livre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('livre_index', [], Response::HTTP_SEE_OTHER);
    }
}
