<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TextHomeRepository;
use App\Entity\TextHome;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TextHomeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TextHomeController extends AbstractController
{
    /**
     * @Route("/text-home/new", name="text_home_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $textHome = new TextHome();
        $form = $this->createForm(TextHomeType::class, $textHome);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($textHome);
            $entityManager->flush();
            return $this->redirectToRoute('about_me');
        }
        return $this->render('text_home/edit.html.twig', [
            'form' => $form->createView(),
            'textHome' => $textHome
        ]);
    }

    /**
     * @Route("/text-home/edit/{id}", name="text_home_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        TextHome $textHome
    ): Response {
        $form = $this->createForm(TextHomeType::class, $textHome);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('about_me');
        }
        return $this->render('text_home/edit.html.twig', [
            'form' => $form->createView(),
            'textHome' => $textHome,
        ]);
    }

    /**
     * @Route("/text-home/delete/{id}", name="text_home_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(
        Request $request,
        EntityManagerInterface $entityManager,
        TextHome $textHome
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $textHome->getId(), $request->request->get('_token'))) {
            $entityManager->remove($textHome);
            $entityManager->flush();
        }
        return $this->redirectToRoute('about_me');
    }
}
