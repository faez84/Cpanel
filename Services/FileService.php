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

/**
 * Class FileService
 *
 * @package syndex\CpanelBundle\Services
 */
class FileService
{
    /**
     * Initiate URL Folder
     * @var
     */
    public $academia_dir;

    /**
     * PubService constructor.
     * @param \Liuggio\ExcelBundle\Factory $phpexcel
     */
    public function __construct($academia_dir)
    {
        $this->academia_dir = $academia_dir;
    }


    //////////////////////// start Product section ////////////////////
    /**
     * Upload a Thumbnail Image
     *
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

        $largthumb = imagecreatetruecolor($lnewwidth, $lnewheight);
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = @imagecreatefromjpeg($file);
        // Resize
        @imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $width, $height);
        // Output
        $filename = (new \DateTime('now'))->getTimestamp();
        imagejpeg($thumb, $dir . $filename . ".jpg");

        return $filename;
    }

    /**
     * Upload a File
     * 
     * @param UploadedFile $file
     * @return string
     */
    public function uploadFile(UploadedFile $file)
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        $file->move($this->academia_dir, $fileName);
        return $fileName;
    }

    /**
     * Remove a File
     * @param $fileName
     * @return bool
     */
    public function removeFile($fileName)
    {

        $file = $this->academia_dir . '/' . $fileName;
        if (file_exists($file)) {
            unlink($file);
            return true;
        }
        return false;
    }
}