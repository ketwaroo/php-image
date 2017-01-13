<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ketwaroo;
use Ketwaroo\Dimension\Box;
/**
 * Description of Image
 *
 * @author Yaasir Ketwaroo<ketwaroo.yaasir@gmail.com>
 */
class Image extends \Imagick
{

    public function __construct($files)
    {
        parent::__construct($files);

        foreach ($this as $f)
        {
            $f->autoRotateImage();
        }
    }
    
    public function readimage($filename)
    {
        $return = parent::readimage($filename);
        $this->autoRotateImage();
    }

    public function autoRotateImage()
    {
        $orientation = $this->getImageOrientation();

        switch ($orientation)
        {
            case self::ORIENTATION_BOTTOMRIGHT:
                $this->rotateimage("#000", 180); // rotate 180 degrees
                break;

            case self::ORIENTATION_RIGHTTOP:
                $this->rotateimage("#000", 90); // rotate 90 degrees CW
                break;

            case self::ORIENTATION_LEFTBOTTOM:
                $this->rotateimage("#000", -90); // rotate 90 degrees CCW
                break;
        }

        // Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
        $this->setImageOrientation(self::ORIENTATION_TOPLEFT);
        return $this;
    }

}
