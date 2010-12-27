<?php
namespace Bundle\Adenclassifieds\ImageResizerBundle\Image;

/**
 * Image Resizes.
 * Host the imagick processsing logic. This is the class you should extends
 * to add custom resizements & processing
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class Resizer
{
    /**
     * Crop center & resize the image
     *
     * @param \Imagick image
     * @param integer width
     * @param integer Height
     */
    public function cropCenter($image, $width, $height)
    {
        $image->cropThumbnailImage($width, $height);
    }

    /**
     * Simples resize broken ratio
     *
     * @param \Imagick image
     * @param integer width
     * @@param integer height
     */
    public function adaptiveResizeImage($image, $width, $height)
    {
        $image->adaptiveResizeImage($width, $height);
    }

    /**
     * Homothetic resizement
     *
     * @param \Imagick image
     * @param integer $maxwidth
     * @param integer $maxheight
     */
    public function homotheticResize($image, $width, $height) {

        list($width,$height) = $this->scaleImage($image->getImageWidth(), $image->getImageHeight(), $width, $height);

        $image->thumbnailImage($width, $height);
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