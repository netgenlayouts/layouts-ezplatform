<?php

namespace Netgen\Bundle\EzPublishBlockManagerBundle\Tests\DependencyInjection;

use Netgen\Bundle\EzPublishBlockManagerBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * @var \Netgen\Bundle\EzPublishBlockManagerBundle\DependencyInjection\Configuration
     */
    protected $configuration;

    public function setUp()
    {
        $this->configuration = new Configuration();
    }

    /**
     * @covers \Netgen\Bundle\EzPublishBlockManagerBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testGetConfigTreeBuilder()
    {
        $this->assertEquals(new TreeBuilder(), $this->configuration->getConfigTreeBuilder());
    }
}