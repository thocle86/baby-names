<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SocialLinkRepository;
use App\Entity\SocialLink;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\SocialLinkType;
use App\Services\FileManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SocialLinkController extends AbstractController
{
    /**
     * @Route("/social-link/new", name="social_link_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        $socialLink = new SocialLink();
        $form = $this->createForm(SocialLinkType::class, $socialLink);
        $form->handleRequest($request);
        $errorAddLogo = '';
        if ($form->isSubmitted() && $form->isValid()) {
            if (
                ($form->get('logo')->getData() !== null)
            ) {
                $addLogo = $fileManager->saveFile(
                    'uploadFile',
                    $form->get('logo')->getData(),
                    $this->getParameter('upload_directory')
                );
                $socialLink->setLogo($addLogo['fileName']);

                $entityManager->persist($socialLink);
                $entityManager->flush();
                return $this->redirectToRoute('about_me');
            } else {
                $errorAddLogo = '⚠️ ATTENTION: vous devez ajouter une photo pour valider le formulaire';
            }
        }
        return $this->render('social_link/edit.html.twig', [
            'form' => $form->createView(),
            'socialLink' => $socialLink,
            'errorAddLogo' => $errorAddLogo
        ]);
    }

    /**
     * @Route("/social-link/edit/{id}", name="social_link_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        SocialLink $socialLink
    ): Response {
        $form = $this->createForm(SocialLinkType::class, $socialLink);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $logo = $form->get('logo')->getData();
            if (
                $logo !== null &&
                $socialLink->getLogo() !== null
            ) {
                $fileManager->deleteFile($socialLink->getLogo(), $this->getParameter('upload_directory'));
                $addLogo = $fileManager->saveFile(
                    'uploadFile',
                    $logo,
                    $this->getParameter('upload_directory')
                );
                $socialLink->setLogo($addLogo['fileName']);
            }
            $entityManager->flush();
            return $this->redirectToRoute('about_me');
        }
        return $this->render('social_link/edit.html.twig', [
            'form' => $form->createView(),
            'socialLink' => $socialLink,
        ]);
    }

    /**
     * @Route("/social-link/delete/{id}", name="social_link_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(
        Request $request,
        EntityManagerInterface $entityManager,
        SocialLink $socialLink
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $socialLink->getId(), $request->request->get('_token'))) {
            $entityManager->remove($socialLink);
            $entityManager->flush();
        }
        return $this->redirectToRoute('about_me');
    }
}
