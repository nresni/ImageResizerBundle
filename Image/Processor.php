<?php
namespace Bundle\Adenclassifieds\ImageResizerBundle\Image;

/**
 * Enter description here ...
 * @author dstendardi
 */
class Processor
{

    /**
     * @var Loader
     */
    protected $loader;

    /**
     * @var Resizer
     */
    protected $resizer;

    /**
     * @var array sizes
     */
    protected $sizes = array();

    /**
     *
     * @param Loader loader
     * @param Resizer resizer
     */
    public function __construct(Loader $loader, Resizer $resizer, array $sizes = array())
    {
        $this->loader = $loader;

        $this->resizer = $resizer;

        $this->sizes = $sizes;
    }

    /**
     * Load a resource (external or local)
     *
     * @param string image url or path
     * @return Resizer instance
     */
    public function load($resource)
    {
        $this->loader->load($resource);

        return $this;
    }

    /**
     * @param string function
     * @param string size
     * @return Imagick Image
     */
    public function process($function, $size)
    {
        if (false === isset($this->sizes[$size])) {
           throw new \InvalidArgumentException();
        }

        list($width, $height) = $this->sizes[$size];

        if (false === is_callable(array($this->resizer, $function))) {
            throw new \InvalidArgumentException();
        }

        $image = $this->loader->image;

        $this->resizer->$function($image, $width, $height);

        $image->unsharpMaskImage(0 , 0.5 , 1 , 0.05);

        return $image;
    }
}