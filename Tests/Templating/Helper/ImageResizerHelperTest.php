<?php
namespace Adenclassifieds\ImageResizerBundle\Tests\Templating\Helper;

use Adenclassifieds\ImageResizerBundle\Templating\Helper\ImageResizerHelper;

/**
 *
 * Enter description here ...
 * @author dstendardi
 */
class ImageResizerHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @cover Adenclassifieds\ImageResizerBundle\Templating\Helper\ImageResizer::image
     */
    public function testImage()
    {
        $helper = $this->getMockBuilder('Adenclassifieds\ImageResizerBundle\Templating\Helper\ImageResizerHelper')->disableOriginalConstructor()->setMethods(array('url', 'getSize', 'getName'))->getMock();

        $helper->expects($this->once())->method('url')->with('foo/bar.png', 'foo', 'bar')->will($this->returnValue('/foo/bar.png'));

        $helper->expects($this->once())->method('getSize')->with('bar')->will($this->returnValue(array('32', '64')));

        $this->assertEquals('<img src="/foo/bar.png" class="test" height="64" width="32"/>', $helper->image('foo/bar.png', 'foo', 'bar', array('class' => 'test')));
    }

    /**
     * @test
     * @cover Adenclassifieds\ImageResizerBundle\Templating\Helper\ImageResizer::url
     */
    public function testUrl()
    {
        $router = $this->getMockBuilder('Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper')->disableOriginalConstructor()->setMethods(array('generate'))->getMock();

        $helper = new ImageResizerHelper($router, array(), array());

        list($function, $size, $src) = array('foo', 'small', 'foo/bar.png');

        $router->expects($this->once())->method('generate')->with('image_resizer_image_resize', array('function' => $function, 'size' => $size, 'resource' => $src))->will($this->returnValue('/foo/bar.png'));

        $this->assertEquals('/foo/bar.png', $helper->url($src, $function, $size));
    }
}