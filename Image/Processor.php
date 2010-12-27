<?php
namespace Bundle\Adenclassifieds\ImageResizerBundle\Image;

/**
 * Image Processor.
 * Wrap other services to load and process image resizements
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class Processor
{
    /**
     * The loader instance
     *
     * @var Loader
     */
    protected $loader;

    /**
     * The resizer instance
     *
     * @var Resizer
     */
    protected $resizer;

    /**
     * A list of acceptables sizes
     *
     * <code>
     * array('medium' => array(120,120))
     * </code>
     *
     * @var array sizes
     */
    protected $sizes = array();

    /**
     * Loads underlaying dependencies and acceptable sizes
     *
     * @param Loader loader
     * @param Resizer resizer
     * @parma array sizes
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
     * Process the resizements, after validation of function & size
     * Given function must be declared in the injected Resizer class
     * Size must be present in this class member
     *
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