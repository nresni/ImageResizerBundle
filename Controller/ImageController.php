<?php
namespace Bundle\Adenclassifieds\ImageResizerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImageController extends Controller
{
    /**
     * <img src="http://images.explorimmo.com/img/s/0/photo/CAIM/explo5054635.jpg" class="defaultImg imgS" alt="Appartement&nbsp;2 pièces&nbsp;2&nbsp;500&nbsp;€&nbsp;FAI&nbsp;Paris 6ème">
     *
     * @param integer size
     * @param string function
     * @param string resource path
     */
    public function resizeAction($size, $function)
    {
        $resource = $this->get('request')->query->get('resource');

        $image = $this->get('imageresizer.processor')->load($resource)->process($function, $size);

        $response = $this->createResponse($image);

        $response->headers->set('Content-Type', $image->getImageType());

        $response->setPublic();

        $response->setMaxAge(86400);

        return $response;
    }
}