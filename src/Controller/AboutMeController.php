<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AboutMeRepository;
use App\Entity\AboutMe;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AboutMeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\SocialLinkRepository;

class AboutMeController extends AbstractController
{
    /**
     * @Route("/", name="about_me")
     */
    public function index(
        AboutMeRepository $abouMeRepository,
        SocialLinkRepository $socialLinkRepository
    ): Response {
        return $this->render('about_me/index.html.twig', [
            'aboutMe' => $abouMeRepository->findAll(),
            'socialLinks' => $socialLinkRepository->findAll()
        ]);
    }

    /**
     * @Route("/about-me/new", name="about_me_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $aboutMe = new AboutMe();
        $form = $this->createForm(AboutMeType::class, $aboutMe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aboutMe);
            $entityManager->flush();
            return $this->redirectToRoute('about_me');
        }
        return $this->render('about_me/edit.html.twig', [
            'form' => $form->createView(),
            'aboutMe' => $aboutMe
        ]);
    }

    /**
     * @Route("/about-me/edit/{id}", name="about_me_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        AboutMe $aboutMe
    ): Response {
        $form = $this->createForm(AboutMeType::class, $aboutMe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('about_me');
        }
        return $this->render('about_me/edit.html.twig', [
            'form' => $form->createView(),
            'aboutMe' => $aboutMe,
        ]);
    }

    /**
     * @Route("/about-me/delete/{id}", name="about_me_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(
        Request $request,
        EntityManagerInterface $entityManager,
        AboutMe $aboutMe
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $aboutMe->getId(), $request->request->get('_token'))) {
            $entityManager->remove($aboutMe);
            $entityManager->flush();
        }
        return $this->redirectToRoute('about_me');
    }
}
