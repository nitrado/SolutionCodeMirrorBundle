<?php

namespace Solution\CodeMirrorBundle\Tests;

use Solution\CodeMirrorBundle\Twig\CodeMirrorExtension;
use Zend\Json\Json;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Solution\CodeMirrorBundle\Tests\App\AppKernel;

class TwigExtensionTest extends WebTestCase
{
    protected $extension;

    protected function setUp(): void
    {
        self::$kernel = new AppKernel('test', true);
        static::$kernel->boot();
        $this->container = static::$kernel->getContainer();
        $this->extension = $this->container->get('code_mirror.twig.extension');
    }

    /**
     * Must be first call by default
     */
    public function testIsFirstCallByDefault()
    {
        $this->assertEquals(true, $this->extension->isFirstCall());

        $this->extension->parametersRender(array());

        $this->assertEquals(false, $this->extension->isFirstCall());
    }

    /**
     * Test render js parameters
     *
     * @dataProvider dataForRenderParameters
     *
     * @param $parameters
     * @param $return
     */
    public function testRenderParameters($parameters, $return)
    {
        $this->assertJsonStringEqualsJsonString((string) $return, (string) $this->extension->parametersRender($parameters));
    }

    /**
     * @return array
     */
    static public function  dataForRenderParameters()
    {
        return array(
            array(
                array(
                    'linenumbers' => true
                ),
                '{"linenumbers":true}'
            ),
            array(
                array(
                    'linenumbers' => true,
                    'mode' => 'text/html'
                ),
                '{"linenumbers":true,"mode":"text/html"}'
            ),
            array(
                array(
                    'linenumbers' => true,
                    'mode' => 'text/html',
                    'theme' => 'eclipse'
                ),
                '{"linenumbers":true,"mode":"text/html","theme":"eclipse"}'
            ),
        );
    }


}
