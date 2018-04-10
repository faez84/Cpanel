<?php
/**
 * Created by PhpStorm.
 * User: LUFFY
 * Date: 11/08/2016
 * Time: 05:47 م
 */

namespace syndex\CpanelBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use syndex\BazaarBundle\Entity\Media;
use syndex\BazaarBundle\Entity\Product;
use syndex\BazaarBundle\Entity\ProductAttributes;
use syndex\BazaarBundle\Entity\PurchaseRequest;
use syndex\BazaarBundle\Entity\Review;
use syndex\BazaarBundle\Entity\Store;
use syndex\BazaarBundle\Entity\UserPreferences;
use syndex\ServicesBundle\Logs\LogService;
use syndex\URLsBundle\Service\QueryProcessService;
use PHPExcel;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class PubService
{
    private $leters = array(
        1 => "A",
        2 => "B",
        3 => "C",
        4 => "D",
        5 => "E",
        6 => "F",
        7 => "G",
        8 => "H",
        9 => "I",
        10 => "J",
        11 => "K",
        12 => "L",
        13 => "M",
        14 => "N",
        15 => "O",
        16 => "P",
        17 => "Q",
        18 => "R",
        19 => "S",
        20 => "T",
        21 => "U",
        22 => "V",
        23 => "W",
        24 => "X",
    );

    private $phpexcel;
    private $academia_dir;

    /**
     * PubService constructor.
     * @param \Liuggio\ExcelBundle\Factory $phpexcel
     */
    public function __construct(\Liuggio\ExcelBundle\Factory $phpexcel, $academia_dir)
    {
        $this->phpexcel = $phpexcel;
        $this->academia_dir = $academia_dir;
    }


    //////////////////////// start Product section ////////////////////
    /**
     * @param $dir
     * @param $file
     * @return int
     */
    public function uploadImage($dir, $file)
    {
        list($width, $height) = getimagesize($file);
        $newwidth = 150;//$width * $percent;
        $newheight = 150;//$height * $percent;
        $lnewwidth = 280;//$width * $percent;
        $lnewheight = 220;//$height * $percent;

// Load
        $largthumb = imagecreatetruecolor($lnewwidth, $lnewheight);
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = @imagecreatefromjpeg($file);

// Resize
        @imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $width, $height);

// Output

        $filename = (new \DateTime('now'))->getTimestamp();

        imagejpeg($thumb, $dir.$filename.".jpg");

        return $filename;
    }

    //////////////////////// start Product section ////////////////////
    /**
     * @param $dir
     * @param $file
     * @return int
     */
    public function uploadOrginalImage(UploadedFile $file)
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        $file->move($this->academia_dir, $fileName);
        return $fileName;
    }
    /**
     * @param $ruler
     * @param $data
     * @param $feilds
     * @param $filename
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \PHPExcel_Exception
     */
    function exportXSL($ruler, $data, $feilds, $filename)
    {
        //$phpExcelObject = new PHPExcel();
        // ask the service for a excel object
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();

//
//    $i=0;
//    foreach ($data as $d) {
//        $i++;
//        $j=1;
//        foreach ($feilds as $f) {
//
//            $phpExcelObject->setActiveSheetIndex(0)
//                ->setCellValue($this->leters[$j] . $i, $d[$f]);
//
//        $j++;
//
//        }
//    }

// ask the service for a excel object
        $phpExcelObject = $this->phpexcel->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("liuggio")
            ->setLastModifiedBy("Giulio De Donato")
            ->setTitle("Office 2005 XLSX Test Document")
            ->setSubject("Office 2005 XLSX Test Document")
            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Test result file");
//    $phpExcelObject->setActiveSheetIndex(0)
//        ->setCellValue('A1', 'Hello')
//        ->setCellValue('B2', 'world!');
        $j = 1;
        foreach ($feilds as $f) {
            $farr = explode(",", $f);
            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue($this->leters[$j]."1", $farr[1]);
            $j = $j + 1;
        }
        $i = 1;
        foreach ($data as $d) {
            $i = $i + 1;
            $j = 1;
            foreach ($feilds as $f) {
                $farr = explode(",", $f);
                $phpExcelObject->setActiveSheetIndex(0)
                    ->setCellValue($this->leters[$j].$i, $d[$farr[0]]);
                $j = $j + 1;
            }
        }
        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);
        // create the writer
        $writer = $this->phpexcel->createWriter($phpExcelObject, 'Excel2007');
        // create the response
        $response = $this->phpexcel->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;

    }
    function sendMSg2User($user, $msg)
    {
        
    }
}