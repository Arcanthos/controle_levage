<?php

namespace App\Controller;

use App\Entity\ControlCompany;
use App\Form\ControlCompanyType;
use App\Repository\ClientCompanyRepository;
use App\Repository\ControlCompanyRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Formatter\FormatterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControlCompanyController extends AbstractController
{
    /**
     * @Route("/control-company-management", name="control_company")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ControlCompanyRepository $companyRepository
     * @return Response
     */
    public function companyManagement(Request $request, EntityManagerInterface $entityManager, ControlCompanyRepository $companyRepository)
    {
        //acces à l'utilisateur connecté et à son instance de company
        $userGranted = $this->getUser();
        $mainCompany = $userGranted->getCompany();

        //création d'un nouveau formulaire et d'une nouvelle instance de company
        $newCompany = new ControlCompany();
        $newCompanyForm = $this->createForm(ControlCompanyType::class, $newCompany);
        $newCompany->setUsers([]);
        $newCompany->setIsMasterCompany(false);
        $newCompany->setIsEnable(true);

        $newCompanyForm->handleRequest($request);
        if ($newCompanyForm->isSubmitted() && $newCompanyForm->isValid()) {
            $entityManager->persist($newCompany);
            $entityManager->flush();

            //clear des champs du formulaire
            unset($newCompany);
            unset($newCompanyForm);
            $newCompany = new ControlCompany();
            $newCompanyForm = $this->createForm(ControlCompanyType::class, $newCompany);
        }


        return $this->render('control_company/newControlCompany.html.twig', [
            'controller_name' => 'ControlCompanyController',
            'newCompanyForm' => $newCompanyForm->createView(),
            'userCompany' => $mainCompany,
            'companyList' => $companyRepository->findAll(),
            'userGrantedCompanyId' => $mainCompany->getId()
        ]);

    }

    /**
     * @Route("/control-company-management/update-mainCompany", name="update-mainCompany")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function editCompany(Request $request, EntityManagerInterface $entityManager)
    {
        $companyToUpdate = $this->getUser()->getCompany();
        $updateCompanyForm = $this->createForm(ControlCompanyType::class, $companyToUpdate);

        $updateCompanyForm->handleRequest($request);
        if ($updateCompanyForm->isSubmitted() && $updateCompanyForm->isValid()) {
            $entityManager->persist($companyToUpdate);
            $entityManager->flush();
        }

        return $this->render('control_company/updateMainCompany.html.twig', [
            'updateCompanyForm' => $updateCompanyForm->createView()
        ]);
    }

    /**
     * @Route("/control-company-management/remove-company/{id}", name="deleteCompany")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ControlCompanyRepository $controlCompanyRepository
     * @param UserRepository $userRepository
     * @param ClientCompanyRepository $clientCompanyRepository
     * @return RedirectResponse
     */
    public function deleteCompany(Request $request, EntityManagerInterface $entityManager, ControlCompanyRepository $controlCompanyRepository, UserRepository $userRepository, ClientCompanyRepository $clientCompanyRepository, $id)
    {
        $companyToDelete = $controlCompanyRepository->find($id);
        $users = $userRepository->findByCompanyId($id);
        $customers = $clientCompanyRepository->findByControlCompanyId($id);

        foreach ($users as $user) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        foreach ($customers as $customer) {
            $entityManager->remove($customer);
            $entityManager->flush();
        }


        $entityManager->remove($companyToDelete);
        $entityManager->flush();

        $this->addFlash('success', 'la société à bien été supprimé !');

        return $this->redirectToRoute('control_company',[
            'idDeleted'=>$id
        ]);
    }


    /**
     * @Route("/control-company-management/disable-company/{id}", name="disableCompany")
     * @param $id
     * @return RedirectResponse
     */
    public
    function disableCompany($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $company = $entityManager->getRepository(ControlCompany::class)->find($id);
        if (!$company) {
            throw $this->createNotFoundException(
                'Pas de company trouvé avec l\'id : ' . $id
            );
        }
        if ($company->getIsEnable() != true) {
            $company->setIsEnable(true);
        } else {
            $company->setIsEnable(false);
        }
        $entityManager->flush();


        return $this->redirectToRoute('control_company', [
            'id' => $company->getId(),
            'isEnable' => $company->getIsEnable()
        ]);
    }

}
