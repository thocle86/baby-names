<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\AboutMeRepository;

class FooterController extends AbstractController
{
    public function getAboutMe(
        AboutMeRepository $aboutMeRepository
    ) {
        return $this->render('_footer.html.twig', [
            'aboutMe' => $aboutMeRepository->findAll(),
        ]);
    }
}
