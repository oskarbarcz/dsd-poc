<?php
/**
 * Created by PhpStorm.
 * User: konta
 * Date: 8 October 2018
 * Time: 22:23
 */

namespace DBLS\Controller;

use Exception;

class UploadCatcher
{

    private $tempPath;

    private $file;

    private $newName;

    private $extention;

    public function __construct($temp)
    {
        $this->tempPath = $temp;
    }

    public function setFile($targetName, $folder)
    {
        $this->newName = $folder . '/' . $targetName;
        switch ($folder) {
            case 'carriers':
                rename($this->file, $this->tempPath . $folder . '/' . $targetName . '.' . $this->extention);

        }
//        echo $this->tempPath . $folder . '/' . $targetName . '.' . $this->extention;
//        die;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function catchImage()
    {
        $target_file = $this->tempPath . 'temp/' . basename($_FILES["logopicker"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size
        if ($_FILES['logopicker']['size'] > 2000000) {
            throw new Exception('Sorry, the file is too large');
        }
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["logopicker"]["tmp_name"]);
        if ($check !== false) {
        } else {
            throw new Exception('Sorry, your file is not an image.');
        }
        // Allow certain file formats
        if (!$this->_checkCorrectFormat($imageFileType)) {
            throw new Exception('Sorry, file has not correct format.');
        }
        $this->extention = $imageFileType;
        // move file to temp folder
        if (move_uploaded_file($_FILES['logopicker']['tmp_name'], $target_file)) {
            $this->file = $target_file;
            return true;
        } else {
            throw new Exception('Sorry, unknown error occured.');
        }
    }

    private function _checkCorrectFormat(string $fmt): bool
    {
        if ($fmt == 'jpg' or $fmt == 'png' or $fmt == 'jpeg') {
            return true;
        } else return false;
    }

    public function changeToJPG()
    {
        $image = imagecreatefrompng($this->tempPath . $this->newName . '.png');
        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
        imagealphablending($bg, true);
        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
        imagedestroy($image);
        $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file
        imagejpeg($bg, $this->tempPath . $this->newName . ".jpg", $quality);
        imagedestroy($bg);
        unlink($this->tempPath . $this->newName . ".png");
    }

    public function applyMaxSizes()
    {

        list($width, $height) = getimagesize($file);
        $ratio = $width / $height;
        if ($ratio > 1) {
            $resized_width = 500; //suppose 500 is max width or height
            $resized_height = 500 / $ratio;
        } else {
            $resized_width = 500 * $ratio;
            $resized_height = 500;
        }

        if ($imageFileType == 'png') {
            $image = imagecreatefrompng($newfile);
        } else if ($imageFileType == 'gif') {
            $image = imagecreatefromgif($newfile);
        } else {
            $image = imagecreatefromjpeg($newfile);
        }

        $resized_image = imagecreatetruecolor($resized_width, $resized_height);
        imagecopyresampled($resized_image, $image, 0, 0, 0, 0, $resized_width, $resized_height, $width, $height);
    }

    /**
     * @return mixed
     */
    public function getExtention()
    {
        return $this->extention;
    }
}