<?php

namespace ZesharCRM\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZesharCRM\Bundle\CoreBundle\Helper\CSVTypes;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Writer\DoctrineWriter;

class CSVController extends Controller
{

    public function importFileAction(Request $request)
    {
        // Get FileId to "import"
        $param = $request->request;

        $curType = trim($param->get("fileType"));
        $uploadedFile = $request->files->get("csvFile");

        // if upload was not ok, just redirect to "shortyStatWrongPArameters"
        if (!CSVTypes::existsType($curType) || $uploadedFile == null) return $this->redirect($this->generateUrl('shortyStatWrongParameters'));

        // generate dummy dir
        $dummyImport = getcwd() . "/csvimport";
        $fname = 'import_' . md5(microtime(TRUE)) . '_' . mt_rand(0, 100000) . '.csv';
        $filename = $dummyImport . "/" . $fname;
        @mkdir($dummyImport);
        @unlink($filename);

        // move file to dummy filename
        $uploadedFile->move($dummyImport, $fname);            

        echo "Starting to Import " . $filename . ", Type: " . CSVTypes::getNameOfType($curType) . "<br />\n";

        // open file
        try {
            $file = new \SplFileObject($filename);
        } catch (\Exception $e) {
            throw new \Exception(sprintf('The path "%s" is invalid', $filename), null, $e);
        }

        // Create and configure the reader
        $csvReader = new CsvReader($file, ",");
        if ($csvReader===false) die("Can't create csvReader $filename");
        $csvReader->setHeaderRowNumber(0);

        // this must be done to import CSVs where one of the data-field has CRs within!
        $file->setFlags(\SplFileObject::READ_CSV |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::READ_AHEAD);

        // Set Database into "nonchecking Foreign Keys"
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->exec("SET FOREIGN_KEY_CHECKS=0;");

        // obtain entity admin class
        $curEntityClass = CSVTypes::getEntityClass($curType);
        $entityAdmin = $this->get('sonata.admin.pool')->getAdminByClass($em->getClassMetadata($curEntityClass)->getName());

        // Create the workflow
        $workflow = new Workflow($csvReader);
        if ($workflow === false) die("Can't create workflow $filename");
        if (method_exists($entityAdmin, 'getImportWorkflowWriter')) {
            $writer = $entityAdmin->getImportWorkflowWriter($em);
        } else {
            $writer = new DoctrineWriter($em, $curEntityClass);
        }
        $writer->setTruncate(false);

        $entityMetadata = $em->getClassMetadata($curEntityClass);
        // $entityMetadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        
        // execute admin service method to act against workflow (i.e. add values converters)
        if (method_exists($entityAdmin, 'setupImportWorkflow')) {
            $entityAdmin->setupImportWorkflow($workflow);
        }

        $workflow->addWriter($writer);

        $readRecordsCount = $workflow->process();

        // RESetting Database Check Status        
        $em->getConnection()->exec("SET FOREIGN_KEY_CHECKS=1;");

        // remove file
        @unlink($filename);
        
        // setup success message and redirect to entities list view
        $this
            ->get('session')
            ->getFlashBag()
            ->add('sonata_flash_success', sprintf('Import successfully finished (%ld records).', $readRecordsCount->getSuccessCount()))
        ;
        return new \Symfony\Component\HttpFoundation\RedirectResponse($entityAdmin->generateUrl('list'));
    }

    public function indexAction()
    {
        /**@var  \Sonata\AdminBundle\Admin\Pool $adminPool */
        $adminPool  = $this->get('sonata.admin.pool');

        return $this->render('ZesharCRMCoreBundle:CSV:import_csv.html.twig', array(
            'admin_pool' => $adminPool,
        ));
    }

}
