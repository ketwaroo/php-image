<?php

namespace Ketwaroo\Dimension;

/**
 * 1x1 minimum box
 *
 * @author Yaasir Ketwaroo
 */
class Box
{

    const dim_min_value = 1;

    protected $width, $height;

    public function __construct($width, $height)
    {
        $this->width  = static::sanitiseDimension($width);
        $this->height = static::sanitiseDimension($height);
    }

    /**
     * 
     * @param int $width
     * @return static
     */
    public function withWidth($width)
    {
        return new static($width, $this->height);
    }

    /**
     * 
     * @param int $height
     * @return static
     */
    public function withHeight($height)
    {
        return new static($this->width, $height);
    }

    /**
     * 
     * @param int $width
     * @param int $height
     * @return static
     */
    public function fitInsideBox($width, $height)
    {
        return $this->makeFit($width, $height, 0);
    }

    /**
     * 
     * @param int $width
     * @param int $height
     * @return static
     */
    public function fitOutsideBox($width, $height)
    {
        return $this->makeFit($width, $height, 1);
    }

    /**
     * 
     * @param int $width
     * @param int $height
     * @param int $inOutFlag 0 = inside, else outside
     * @return static
     */
    protected function makeFit($width, $height, $inOutFlag)
    {
        $width  = static::sanitiseDimension($width);
        $height = static::sanitiseDimension($height);

        $widerBy  = $width / $this->width;
        $higherBy = $height / $this->height;

        $scale = $inOutFlag === 0 ? max($widerBy, $higherBy) : min($widerBy, $higherBy);

        return new static($width / $scale, $height / $scale);
    }

    /**
     * 
     * @param int $witdh
     * @return static
     */
    public function scaleToWidth($witdh)
    {
        $container = new static($witdh, 1);
        return $container->fitOutsideBox($this->getWidth(), $this->getHeight());
    }

    /**
     * 
     * @param int $height
     * @return static
     */
    public function scaleToHeight($height)
    {
        $container = new static(1, $height);
        return $container->fitOutsideBox($this->getWidth(), $this->getHeight());
    }

    /**
     * 
     * @param int $width
     * @param int $height
     * @return static
     */
    public function scaleToFit($width, $height)
    {
        $container = new static($width, $height);
        return $container->fitInsideBox($this->getWidth(), $this->getHeight());
    }

    /**
     * 
     * @param int $width
     * @param int $height
     * @return static
     */
    public function scaleToFitOutside($width, $height)
    {
        $container = new static($width, $height);
        return $container->fitOutsideBox($this->getWidth(), $this->getHeight());
    }

    /**
     * 
     * @return int
     */
    function getWidth()
    {
        return $this->width;
    }

    /**
     * 
     * @return int
     */
    function getHeight()
    {
        return $this->height;
    }

    /**
     * for use with list() usually
     * @return array
     */
    public function getWidthHeightArray()
    {
        return [$this->getWidth(), $this->getHeight()];
    }

    /**
     * 
     * @param mixed $dim
     * @return int >=1
     */
    public static function sanitiseDimension($dim)
    {
        return max(static::dim_min_value, intval($dim));
    }

}
