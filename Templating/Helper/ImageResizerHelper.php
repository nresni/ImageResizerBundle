<?php
namespace Bundle\Adenclassifieds\ImageResizerBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper as BaseHelper;

/**
 * @author dstendardi
 */
class ImageResizerHelper extends BaseHelper
{
    /**
     * @var RouterHelper $router;
     */
    protected $router;

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
     * Dependencies
     *
     * @param RouterHelper
     */
    public function __construct(RouterHelper $router, array $sizes, array $functions)
    {
      $this->router = $router;
    }

    /**
     * Generates the resizement target url
     *
     * @param string src
     * @param string function
     * @param string size
     * @return string the resizement url
     */
    public function url($src, $function, $size)
    {
      return $this->router->generate('image_resizer_image_resize', array('function' => $function, 'size' => $size, 'resource' => $src));
    }

    /**
     * @param string src
     * @param string function
     * @param string size
     * @param array attributes
     */
    public function image($src, $function, $size, array $attributes = array())
    {
        list($attributes['width'], $attributes['height']) = $this->getSize($size);

        $buffer = '';
        foreach ($attributes as $key => $value) {
            $buffer .= ' '.sprintf('%s="%s"', $key, htmlspecialchars($value, ENT_QUOTES, $this->charset));
        }

        return sprintf('<img src="%s"%s/>', $this->url($src, $function, $size), $buffer);
    }

    /**
     * Get width and height by named size
     *
     * @param string named size
     * @return array width, height
     */
    protected function getSize($size)
    {
        if (false === isset($this->sizes[$size])) {
           throw new \InvalidArgumentException("Undefined size : <$size>");
        }

        return $this->sizes[$size];
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     */
    public function getName()
    {
        return 'imageresizer';
    }
}