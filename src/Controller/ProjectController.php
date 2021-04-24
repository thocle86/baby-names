<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;
use App\Entity\Project;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="project")
     */
    public function indexProject(
        ProjectRepository $projectRepository
    ): Response {
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'projects' => $projectRepository->findBy(
                [],
                ['position' => 'ASC'],
            )
        ]);
    }

    /**
     * @Route("/project/new", name="project_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function newProject(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('project');
        }
        return $this->render('project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project
        ]);
    }

    /**
     * @Route("/project/edit/{id}", name="project_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editProject(
        Request $request,
        EntityManagerInterface $entityManager,
        Project $project
    ): Response {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('project');
        }
        return $this->render('project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }

    /**
     * @Route("/project/delete/{id}", name="project_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteProject(
        Request $request,
        EntityManagerInterface $entityManager,
        Project $project
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
        }
        return $this->redirectToRoute('project');
    }
}
