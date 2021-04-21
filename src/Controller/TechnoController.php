<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TechnoRepository;
use App\Entity\Techno;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TechnoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TechnoController extends AbstractController
{
    /**
     * @Route("/techno/new", name="techno_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function newTechno(
        Request $request,
        EntityManagerInterface $entityManager,
        TechnoRepository $technoRepository
    ): Response {
        $technos = $technoRepository->findAll();
        $techno = new Techno();
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($techno);
            $entityManager->flush();
            return $this->redirectToRoute('techno_new');
        }
        return $this->render('techno/edit.html.twig', [
            'form' => $form->createView(),
            'techno' => $techno,
            'technos' => $technos
        ]);
    }

    /**
     * @Route("/techno/edit/{id}", name="techno_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editTechno(
        Request $request,
        EntityManagerInterface $entityManager,
        Techno $techno,
        TechnoRepository $technoRepository
    ): Response {
        $technos = $technoRepository->findAll();
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('techno_new');
        }
        return $this->render('techno/edit.html.twig', [
            'form' => $form->createView(),
            'techno' => $techno,
            'technos' => $technos
        ]);
    }

    /**
     * @Route("/techno/delete/{id}", name="techno_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteTechno(
        Request $request,
        EntityManagerInterface $entityManager,
        Techno $techno
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $techno->getId(), $request->request->get('_token'))) {
            $entityManager->remove($techno);
            $entityManager->flush();
        }
        return $this->redirectToRoute('techno_new');
    }
}
