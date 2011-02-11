<?php
namespace Adenclassifieds\ImageResizerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 *
 * Enter description here ...
 * @author dstendardi
 */
class ImageResizerBundle extends Bundle
{

  public function getNamespace()
  {
    return __NAMESPACE__;
  }

  public function getPath()
  {
    return __DIR__;
  }

}