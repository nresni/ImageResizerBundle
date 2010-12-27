<?php
namespace Bundle\Adenclassifieds\ImageResizerBundle\Image;

use Doctrine\Common\Cache\AbstractCache;

/**
 *
 * Enter description here ...
 * @author dstendardi
 */
class Loader
{
    /**
     * @var Imagick
     */
    protected $imagick;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @param Imagick image
     * @param Cache cache
     * @param string base path
     */
    public function __construct(\Imagick $image, AbstractCache $cache, $basePath)
    {
      $this->image = $image;

      $this->cache = $cache;

      $this->basePath = $basePath;
    }


    /**
     * Load a resource (external or local)
     *
     * @param string image url or path
     * @return Resizer instance
     */
    public function load($resource)
    {
        if (strpos($resource, 'http') === 0) {
            $content = $this->loadExternalImage($resource);
            $this->image->readImageBlob($content);
        } else {
            $fullPath = $this->basePath .'/'. $resource;
            $this->image->readImage($fullPath);
        }

        return $this;
    }

    /**
     * @throws Exception
     */
    protected function loadExternalImage($resource)
    {
        if ($content= $this->cache->fetch($resource)) {
          return $content;
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $resource);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        $content = curl_exec($curl);
        curl_close($curl);

        if ( ! $content) {
            throw new Exception();
        }

        $this->cache->save($resource, $content);

        return $content;
    }

}