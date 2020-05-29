<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class ContactController extends AbstractController
{
    /**
     * @Route("/CreateContact", name="createContact")
     */
    public function createContact(Request $request, EntityManagerInterface $em)
    {

        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'Contact enregistré ! ');
        }
        return $this->render('contact/createContact.html.twig', [
            'controller_name' => 'ContactController',
            'contactForm' => $contactForm->createView()
        ]);
    }


}
