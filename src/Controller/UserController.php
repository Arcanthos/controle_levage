<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NewUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/new-user", name="newUser")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function nouvelleUtilisateur(Request $request , EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        // instanciation des différents éléments du formulaire
        $user = new User();
        $newUserForm = $this->createForm(NewUserFormType::class, $user);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_CONTROLLER']);

        // gestion de la requete  et de la persistance des données
        $newUserForm->handleRequest($request);
        if ($newUserForm->isSubmitted() && $newUserForm->isValid()){
            // hashage du mot de passe saisi
            $hashed = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashed);

            //persistance des données dans la DB
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/newUser.html.twig', [
            'controller_name' => 'UserController',
            'newUserForm'=>$newUserForm->createView()
        ]);
    }



}
