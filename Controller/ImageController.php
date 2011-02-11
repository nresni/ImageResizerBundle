<?php
namespace Adenclassifieds\ImageResizerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * ImageController.
 *
 * @author David Stendardi <david.stendardi@adenclassifieds.com>
 */
class ImageController extends Controller
{
    /**
     * Process image resizement, using underlaying services
     *
     * @param integer size
     * @param string function
     * @return Symfony\Components\HttpKernel\Response
     */
    public function resizeAction($size, $function)
    {
        $resource = $this->get('request')->query->get('resource');

        $image = $this->get('imageresizer')->load($resource)->process($function, $size);

        $response = $this->createResponse($image);

        $response->headers->set('Content-Type', $image->getImageType());

        $response->setPublic();

        $response->setMaxAge(86400);

        return $response;
    }
}