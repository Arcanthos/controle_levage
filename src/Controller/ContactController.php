<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ClientCompanyRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class ContactController extends AbstractController
{
    /**
     * @Route("/createContact/{idClientCompany}", name="createContact", requirements={"idClientCompany": "\d+"} )
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $idClientCompany
     * @param ClientCompanyRepository $clientCompanyRepo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createContact(Request $request, EntityManagerInterface $em, $idClientCompany, ClientCompanyRepository $clientCompanyRepo)
    {
        //initialisation du formulaire de création d'un nouveau contact dans la société cliente
        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class, $contact);

        //persistance du nouveau contact
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid())
        {
            //Récupération de la société cliente
            $contact ->setClientCompany($clientCompanyRepo->find($idClientCompany));

            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'Contact enregistré ! ');
            return $this->redirectToRoute('detail_client_company', [
                'id'=>$idClientCompany,
            ]);
        }
        return $this->render('contact/createContact.html.twig', [
            'controller_name' => 'ContactController',
            'contactForm' => $contactForm->createView(),
            'id'=>$idClientCompany,
        ]);
    }

    /**
     * @Route("/edit-contact/{id}", name="edit_contact", requirements={"id": "\d+"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ContactRepository $contactRepo
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editContact(Request $request, EntityManagerInterface $em, ContactRepository $contactRepo, $id)
    {
        $contact = $contactRepo->find($id);
        $editContactForm = $this->createForm(ContactType::class, $contact);
        $editContactForm->handleRequest($request);

        if($editContactForm->isSubmitted()&& $editContactForm->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('detail_client_company', [
                'id'=>$contact->getClientCompany()->getId(),
            ]);
        }
        return $this->render('contact/editContact.html.twig',[
            'editContactForm'=>$editContactForm->createView(),
            'contact'=>$contact,
        ]);
    }


    /**
     * @Route("/delete-contact/{id}", name="delete_contact", requirements={"id": "\d+"})
     * @param EntityManagerInterface $em
     * @param ContactRepository $contactRepo
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteContact(EntityManagerInterface $em, ContactRepository $contactRepo, $id)
    {
        $contact = $contactRepo->find($id);
        $idCompany = $contact->getClientCompany()->getId();
        $em->remove($contact);
        $em->flush();
        $this->addFlash('success', 'Le contact a bien été supprimé');
        return $this->redirectToRoute('detail_client_company', [
            'id'=>$idCompany,
        ]);
    }
}
