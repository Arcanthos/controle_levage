<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Repository\ClientCompanyRepository;
use App\Repository\EquipmentRepository;
use App\Repository\QuoteRepository;
use DateInterval;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class DevisController extends AbstractController
{
    const PERIODIC = 'Periodic';
    const COMMISSIONING = 'Commissioning';
    const RETURNTOSERVICE = 'ReturnToService';

    /**
     * @Route("/new-devis/{equipmentControlList}", name="newDevis",)
     * @param $equipmentControlList
     * @param EquipmentRepository $equipmentRepository
     * @param ClientCompanyRepository $clientCompanyRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newDevis($equipmentControlList, EquipmentRepository $equipmentRepository, ClientCompanyRepository $clientCompanyRepository, EntityManagerInterface $entityManager)
    {
        //création d'une nouvelle instance de devis
        $newDevis = new Quote();
        $newDevis->setSerializedContent($equipmentControlList);

        $clientCompany = null;
        $controlCompany = null;

        //recupération des valeurs passé en parametre
        $equipmentsToControl = [];
        $equipmentControlList = unserialize($equipmentControlList);
        $allEquipments = $equipmentRepository->findAll();


        foreach ($equipmentControlList as $equipmentID => $controlType) {
            if($controlType != 'null'){
                $equipment = $equipmentRepository->find($equipmentID);
                $equipment->setDevis($newDevis);
                array_push($equipmentsToControl, $equipment);

                //Valeur de la société cliente et de la société controlleuse -- pas optimal mais pas problematique car valeur identique d'un élément à l'autre
                $clientCompany = $clientCompanyRepository->find($equipment->getClientCompany()->getId());
                $controlCompany = $clientCompany->getControlCompany();

            }

        }

        $pdfId = uniqid();
        //generation du pdf
        //options du pdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        //instantiation d'un nouveau DOM pdf
        $dompdf = new Dompdf($pdfOptions);

        //retourner le fichier html dans le fichier twig
        $html = $this->renderView('devis/devisPdf.html.twig', [
            'title' => 'Devis',
            'clientCompany' => $clientCompany,
            'controlCompany' => $controlCompany,
            'devis' => $newDevis,
            'EquipmentsToControl' => $equipmentControlList,
            'allEquipments'=>$allEquipments,
            'dateTime' => (new \DateTime('now'))->format("d-m-Y"),
            'endTime' => ((new \DateTime('now'))->add(new DateInterval('P1M'))->format("d-m-Y")),
            'pdfId' => $pdfId
        ]);

        //chargement du html dans le dompdf
        $dompdf->loadHtml($html);

        //parametre du dompdf
        $dompdf->setPaper('A4', 'portrait');

        // Rendu du html en pdf
        $dompdf->render();
        $output = $dompdf->output();

        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/PDF/devis';

        $pdfFilepath = $publicDirectory . '/' . $pdfId . '.pdf';
        $assetPdfFilePath = 'PDF/devis/' . $pdfId . '.pdf';
        file_put_contents($pdfFilepath, $output);

        //sauvegarde du devis créé en DB et mise à jour de l'état de devis dans l'équipement
        $newDevis->setDate(new \DateTime('now'));
        $newDevis->setPdfPath($assetPdfFilePath);
        $newDevis->setIsOpen(true);
        $newDevis->setEquipments($equipmentsToControl);
        $newDevis->setClientCompany($clientCompany);



        try {
            $entityManager->persist($newDevis);
            $entityManager->flush();
        } catch (ORMException $e) {
            echo("ERREUR, le devis n'a pas pu être enregistré");
        }


        return $this->render('devis/new.html.twig', [
            'controller_name' => 'DevisController',
            'clientCompany' => $clientCompany,
            'controlCompany' => $controlCompany,
            'devis' => $newDevis,
            'EquipmentsToControl' => $equipmentControlList,
            'allEquipments'=>$allEquipments,
            'periodic' => self::PERIODIC,
            'commissioning' => self::COMMISSIONING,
            'returnToService' => self::RETURNTOSERVICE
        ]);
    }


    /**
     * @Route("/devis-manager", name="devisManager")
     * @param QuoteRepository $devisRepository
     * @return Response
     */
    public function devisManager(QuoteRepository $devisRepository)
    {
        $allDevis = $devisRepository->findAll();
        $devisToManage = [];

        foreach ($allDevis as $devis){
            if($devis->getIsOpen() == true){
                array_push($devisToManage, $devis);
            }
        }

        return $this->render('devis/devisManager.html.twig', [
            'devisOpen' => $devisToManage
        ]);
    }


}
