<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
class DevisController extends AbstractController
{
    /**
     * @Route("/new-devis/{equipmentID}", name="newDevis")
     * @param $equipmentID
     * @param EquipmentRepository $equipmentRepository
     * @param EntityManager $entityManager
     * @return Response
     */
    public function newDevis($equipmentID, EquipmentRepository $equipmentRepository, EntityManagerInterface $entityManager)
    {
        $equipmentToControl = $equipmentRepository->find($equipmentID);
        $newDevis = new Quote();
        $clientCompany = $equipmentToControl->getClientCompany();
        $controlCompany = $clientCompany->getControlCompany();

        //sauvegarde du devis créé en DB
        $newDevis->setDate(new \DateTime('now'));
        try {
            $entityManager->persist($newDevis);
            $entityManager->flush();
        } catch (ORMException $e) {
            echo("ERREUR, le devis n'a pas pu être enregistré");
        }

        //generation du pdf
        //options du pdf
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        //instantiation d'un nouveau DOM pdf
        $dompdf = new Dompdf($pdfOptions);

        //retourner le fichier html dans le fichier twig
        $html = $this->renderView('devis/devisPdf.html.twig', [
            'title'=>'Devis'
        ]);

        //chargement du html dans le dompdf
        $dompdf->loadHtml($html);

        //parametre du dompdf
        $dompdf->setPaper('A4', 'portrait');

        // Rendu du html en pdf
        $dompdf->render();

        // transformation des données du dompdf en données binaires
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/PDF/devis';

        $pdfFilepath =  $publicDirectory . '/'.$equipmentToControl->getModel().$equipmentToControl->getClientCompany()->getName().'.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);



        return $this->render('devis/new.html.twig', [
            'controller_name' => 'DevisController',
            'clientCompany'=>$clientCompany,
            'controlCompany'=>$controlCompany,
            'devis'=>$newDevis,
            'EquipmentToControl'=>$equipmentToControl
        ]);
    }
}
