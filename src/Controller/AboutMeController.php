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
use App\Services\FileManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AboutMeController extends AbstractController
{
    /**
     * @Route("/", name="about_me")
     */
    public function index(
        AboutMeRepository $abouMeRepository
    ): Response {
        $aboutMe = $abouMeRepository->findAll();
        return $this->render('about_me/index.html.twig', [
            'aboutMe' => $aboutMe,
        ]);
    }

    /**
     * @Route("/aboutme/new", name="about_me_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        $aboutMe = new AboutMe();
        $form = $this->createForm(AboutMeType::class, $aboutMe);
        $form->handleRequest($request);
        $errorAddAvatar = '';
        if ($form->isSubmitted() && $form->isValid()) {
            if (
                ($form->get('avatar')->getData() !== null)
            ) {
                $addAvatar = $fileManager->saveFile(
                    'uploadFile',
                    $form->get('avatar')->getData(),
                    $this->getParameter('upload_directory')
                );
                $aboutMe->setAvatar($addAvatar['fileName']);

                $entityManager->persist($aboutMe);
                $entityManager->flush();
                return $this->redirectToRoute('about_me');
            } else {
                $errorAddAvatar = '⚠️ ATTENTION: vous devez ajouter une photo pour valider le formulaire';
            }
        }
        return $this->render('about_me/edit.html.twig', [
            'form' => $form->createView(),
            'aboutMe' => $aboutMe,
            'errorAddAvatar' => $errorAddAvatar
        ]);
    }

    /**
     * @Route("/aboutme/edit/{id}", name="about_me_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager,
        AboutMe $aboutMe
    ): Response {
        $form = $this->createForm(AboutMeType::class, $aboutMe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $form->get('avatar')->getData();
            if (
                $avatar !== null &&
                $aboutMe->getAvatar() !== null
            ) {
                $fileManager->deleteFile($aboutMe->getAvatar(), $this->getParameter('upload_directory'));
                $addAvatar = $fileManager->saveFile(
                    'uploadFile',
                    $avatar,
                    $this->getParameter('upload_directory')
                );
                $aboutMe->setAvatar($addAvatar['fileName']);
            }
            $entityManager->flush();
            return $this->redirectToRoute('about_me');
        }
        return $this->render('about_me/edit.html.twig', [
            'form' => $form->createView(),
            'aboutMe' => $aboutMe,
        ]);
    }

    /**
     * @Route("/aboutme/delete/{id}", name="about_me_delete", methods={"DELETE"})
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
