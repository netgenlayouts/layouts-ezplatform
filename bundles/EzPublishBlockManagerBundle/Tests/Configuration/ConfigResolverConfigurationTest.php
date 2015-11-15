<?php

namespace Netgen\Bundle\EzPublishBlockManagerBundle\Tests\Configuration;

use Netgen\Bundle\EzPublishBlockManagerBundle\Configuration\ConfigResolverConfiguration;
use PHPUnit_Framework_TestCase;

class ConfigResolverConfigurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Sets up the tests
     */
    protected function setUp()
    {
        if (!interface_exists('eZ\Publish\Core\MVC\ConfigResolverInterface')) {
            $this->markTestSkipped('No eZ Publish installed, ConfigResolverConfiguration tests skipped.');
        }
    }

    /**
     * @covers \Netgen\BlockManager\Configuration\ConfigResolverConfiguration::hasParameter
     */
    public function testHasParameter()
    {
        $configResolver = $this->getMock('eZ\Publish\Core\MVC\ConfigResolverInterface');
        $configResolver
            ->expects($this->once())
            ->method('hasParameter')
            ->with($this->equalTo('some_param'), $this->equalTo('netgen_block_manager'))
            ->will($this->returnValue(true));

        $configuration = new ConfigResolverConfiguration();
        $configuration->setConfigResolver($configResolver);
        self::assertEquals(true, $configuration->hasParameter('some_param'));
    }

    /**
     * @covers \Netgen\BlockManager\Configuration\ConfigResolverConfiguration::hasParameter
     */
    public function testHasParameterWithNoParameter()
    {
        $configResolver = $this->getMock('eZ\Publish\Core\MVC\ConfigResolverInterface');
        $configResolver
            ->expects($this->once())
            ->method('hasParameter')
            ->with($this->equalTo('some_param'), $this->equalTo('netgen_block_manager'))
            ->will($this->returnValue(false));

        $configuration = new ConfigResolverConfiguration();
        $configuration->setConfigResolver($configResolver);
        self::assertEquals(false, $configuration->hasParameter('some_param'));
    }

    /**
     * @covers \Netgen\BlockManager\Configuration\ConfigResolverConfiguration::getParameter
     */
    public function testGetParameter()
    {
        $configResolver = $this->getMock('eZ\Publish\Core\MVC\ConfigResolverInterface');
        $configResolver
            ->expects($this->once())
            ->method('hasParameter')
            ->with($this->equalTo('some_param'), $this->equalTo('netgen_block_manager'))
            ->will($this->returnValue(true));
        $configResolver
            ->expects($this->once())
            ->method('getParameter')
            ->with($this->equalTo('some_param'), $this->equalTo('netgen_block_manager'))
            ->will($this->returnValue('some_param_value'));

        $configuration = new ConfigResolverConfiguration();
        $configuration->setConfigResolver($configResolver);
        self::assertEquals('some_param_value', $configuration->getParameter('some_param'));
    }

    /**
     * @covers \Netgen\BlockManager\Configuration\ConfigResolverConfiguration::getParameter
     * @expectedException \Netgen\BlockManager\Exceptions\InvalidArgumentException
     */
    public function testGetParameterThrowsInvalidArgumentException()
    {
        $configResolver = $this->getMock('eZ\Publish\Core\MVC\ConfigResolverInterface');
        $configResolver
            ->expects($this->once())
            ->method('hasParameter')
            ->with($this->equalTo('some_param'), $this->equalTo('netgen_block_manager'))
            ->will($this->returnValue(false));

        $configuration = new ConfigResolverConfiguration();
        $configuration->setConfigResolver($configResolver);
        $configuration->getParameter('some_param');
    }
}
