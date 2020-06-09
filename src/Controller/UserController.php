<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NewUserFormType;
use Doctrine\ORM\EntityManagerInterface;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/new-user", name="newUser")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $encoder
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function newUser(Request $request , EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, MailerInterface $mailer)
    {
        // instanciation des différents éléments du formulaire
        $user = new User();
        $newUserForm = $this->createForm(NewUserFormType::class, $user);
        $user->setIsActive(true);
        $user->setRoles(['ROLE_CONTROLLER']);
        $user->setCompany($this->getUser()->getCompany());


        $autoGeneratedPassword = $this->randomChainGenerator(15);
        $user->setPassword($autoGeneratedPassword);


        // gestion de la requete  et de la persistance des données
        $newUserForm->handleRequest($request);

        if ($newUserForm->isSubmitted() && $newUserForm->isValid()){
            $this->sendMailRegistered($user->getEmail(), $user->getFirstname(), $user->getUsername(), $user->getPassword(), $user->getCompany()->getName(), $mailer);

            // hashage du mot de passe saisi
            $hashed = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashed);

            //persistance des données dans la DB
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('homePanel');
        }

        return $this->render('user/newUser.html.twig', [
            'controller_name' => 'UserController',
            'newUserForm'=>$newUserForm->createView()
        ]);
    }


    /**
     * @param $email
     * @param $firstname
     * @param $username
     * @param $password
     * @param $company
     * @param MailerInterface $mailer
     *
     * @throws TransportExceptionInterface
     *
     *
     */
    public function sendMailRegistered($email, $firstname, $username, $password, $company, MailerInterface $mailer){

        $emailNewUser = (new  Email())
            ->from('devtest44444@gmail.com')
            ->to($email)
            ->subject('Votre compte utilisateur a été créé')
            ->html('<p>Bonjour '.$firstname.'<p><br>
                    <p>Voici tes identifiants  pour le site de controle de '.$company.'</p><br>
                    <p>Login : '.$username.'</p><br>
                    <p>Mot de passe : '.$password.'</p>');

        $emailNewUser->Charset = 'UTF-8';
        $emailNewUser->Encoding = 'base64';
        $mailer->send($emailNewUser);


    }

    /**
     * @param int $longueur
     * @return string
     */
    public function randomChainGenerator($longueur = 10)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $maxLen = strlen($caracteres);
        $randomChain = '';
        for ($i = 0; $i < $longueur; $i++)
        {
            $randomChain .= $caracteres[rand(0, $maxLen - 1)];
        }
        return $randomChain;
    }


    /**
     * @Route("/admin/managing-user", name="userManagement")
     */
    public function userManagement(){
        return $this->render('user/userManagement.html.twig');
    }

}
