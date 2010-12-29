<?php
namespace Bundle\Adenclassifieds\ImageResizerBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Bundle\FrameworkBundle\Templating\Helper;

/**
 * @author dstendardi
 */
class ImageResizerBundle extends BaseHelper
{
    /**
     * @var RouterHelper $router;
     */
    protected $router;

    /**
     * Dependencies
     *
     * @param RouterHelper
     */
    public function __construct(RouterHelper $router)
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
    public function resize($src, $function, $size)
    {
      return $this->router->generate('image_resizer_image_resize', array('function' => $function, 'size' => $size, 'resource' => $src));
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