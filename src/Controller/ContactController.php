<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(
        Request $request,
        MailerInterface $mailer
    ): Response {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            
            $email = (new Email())
                ->from($contactFormData['email'])
                ->to('contact@thomas-clement.com')
                ->subject($contactFormData['subject'])
                ->text(
                    'Emetteur : '.$contactFormData['transmitter'].\PHP_EOL.
                    $contactFormData['message'],
                    'text/plain');
            try {
                $mailer->send($email);
                $this->addFlash("success", "Votre message a été envoyé avec succès");
            } catch (TransportExceptionInterface $e) {
                $this->addFlash("warning", "Votre message n'a pas été envoyé, vérifier votre email");
            }
            return $this->redirectToRoute('contact');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
