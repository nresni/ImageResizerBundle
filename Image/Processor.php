<?php
namespace Adenclassifieds\ImageResizerBundle\Image;

/**
 * Image Resizes.
 * Host the imagick processing logic. This is the class you should extend
 * to add custom resizements & processing
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class Processor
{
    /**
     * Crop center & resize the image
     *
     * @param \Imagick image
     * @param integer width
     * @param integer Height
     */
    public function cropCenter(\Imagick $image, $width, $height)
    {
        $image->cropThumbnailImage($width, $height);

        $image->unsharpMaskImage(0 , 0.5 , 1 , 0.05);
    }

    /**
     * Simples resize broken ratio
     *
     * @param \Imagick image
     * @param integer width
     * @@param integer height
     */
    public function adaptive(\Imagick $image, $width, $height)
    {
        $image->adaptiveResizeImage($width, $height);

        $image->unsharpMaskImage(0 , 0.5 , 1 , 0.05);
    }

    /**
     * Homothetic resizement
     *
     * @param \Imagick image
     * @param integer $maxwidth
     * @param integer $maxheight
     */
    public function homothetic(\Imagick $image, $width, $height)
    {
        list($width, $height) = $this->scaleImage($image->getImageWidth(), $image->getImageHeight(), $width, $height);

        $image->thumbnailImage($width, $height);

        $image->unsharpMaskImage(0 , 0.5 , 1 , 0.05);
    }

    /**
     * @param Original X size in pixels
     * @param Original Y size in pixels
     * @param New X maximum size in pixels
     * @param New Y maximum size in pixels
     */
    protected function scaleImage($width, $height, $maximumWidth, $maximumHeight)
    {
        list($nx, $ny) = array($width, $height);

        if ($width >= $maximumWidth || $height >= $maximumHeight) {

            if ($width > 0) {
                $rx = $maximumWidth / $width;
            }
            if ($height > 0) {
                $ry = $maximumHeight / $height;
            }

            if ($rx > $ry) {
                $r = $ry;
            } else {
                $r = $rx;
            }

            $nx = intval($width * $r);

            $ny = intval($height * $r);
        }

        return array($nx, $ny);
    }
}