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
use App\Services\FileManager;
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
        FileManager $fileManager,
        TechnoRepository $technoRepository
    ): Response {
        $technos = $technoRepository->findAll();
        $techno = new Techno();
        $form = $this->createForm(TechnoType::class, $techno);
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
                $techno->setLogo($addLogo['fileName']);

                $entityManager->persist($techno);
                $entityManager->flush();
                return $this->redirectToRoute('techno_new');
            } else {
                $errorAddLogo = '⚠️ ATTENTION: vous devez ajouter une logo pour valider le formulaire';
            }
        }
        return $this->render('techno/edit.html.twig', [
            'form' => $form->createView(),
            'techno' => $techno,
            'errorAddLogo' => $errorAddLogo,
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
        FileManager $fileManager,
        Techno $techno,
        TechnoRepository $technoRepository
    ): Response {
        $technos = $technoRepository->findAll();
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $logo = $form->get('logo')->getData();
            if (
                $logo !== null &&
                $techno->getLogo() !== null
            ) {
                $fileManager->deleteFile($techno->getLogo(), $this->getParameter('upload_directory'));
                $addLogo = $fileManager->saveFile(
                    'uploadFile',
                    $logo,
                    $this->getParameter('upload_directory')
                );
                $techno->setLogo($addLogo['fileName']);
            }
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
