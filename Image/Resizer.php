<?php
namespace Adenclassifieds\ImageResizerBundle\Image;

/**
 * Wrap other services to load and process image resizements
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class Resizer
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
    protected $processor;

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
     * The functions allowed
     *
     * @var array functions
     */
    protected $functions;

    /**
     * Loads underlaying dependencies and acceptable sizes
     *
     * @param Loader loader
     * @param Resizer resizer
     * @parma array sizes
     */
    public function __construct(Loader $loader, Processor $processor, array $sizes = array(), array $functions = array())
    {
        $this->loader = $loader;

        $this->processor = $processor;

        $this->sizes = $sizes;

        $this->functions = $functions;
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

        if (false === in_array($function, $this->functions) || false === is_callable(array($this->processor, $function))) {
            throw new \InvalidArgumentException();
        }

        $image = $this->loader->image;

        $this->processor->$function($image, $width, $height);

        return $image;
    }
}