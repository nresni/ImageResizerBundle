<?php
namespace Bundle\Adenclassifieds\ImageResizerBundle\Tests\Templating\Helper;

use Bundle\Adenclassifieds\ImageResizerBundle\Templating\Helper;

/**
 *
 * Enter description here ...
 * @author dstendardi
 */
class ImageResizerHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @cover Bundle\Adenclassifieds\ImageResizerBundle\Templating\Helper\ImageResizer::image
     */
    public function testImage()
    {
        $this->helper = $this->getMockBuilder('Bundle\Adenclassifieds\ImageResizerBundle\Templating\Helper\ImageResizerHelper')->disableOriginalConstructor()->setMethods(array('url', 'getSize', 'getName'))->getMock();

        $this->helper->expects($this->once())->method('url')->with('foo/bar.png', 'foo', 'bar')->will($this->returnValue('/foo/bar.png'));

        $this->helper->expects($this->once())->method('getSize')->with('bar')->will($this->returnValue(array('32', '64')));

        $this->assertEquals('<img src="/foo/bar.png" class="test" height="64" width="32"/>', $this->helper->image('foo/bar.png', 'foo', 'bar', array('class' => 'test')));
    }
}