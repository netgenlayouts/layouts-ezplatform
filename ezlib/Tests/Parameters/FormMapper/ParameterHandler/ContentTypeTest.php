<?php

namespace Netgen\BlockManager\Ez\Tests\Parameters\FormMapper\ParameterHandler;

use Netgen\BlockManager\Ez\Form\ContentTypeType;
use Netgen\BlockManager\Ez\Parameters\Parameter\ContentType as ContentTypeParameter;
use Netgen\BlockManager\Ez\Parameters\FormMapper\ParameterHandler\ContentType;
use Netgen\BlockManager\Parameters\FormMapper\ParameterHandler;
use PHPUnit\Framework\TestCase;

class ContentTypeTest extends TestCase
{
    /**
     * @var \Netgen\BlockManager\Ez\Parameters\FormMapper\ParameterHandler\ContentType
     */
    protected $parameterHandler;

    public function setUp()
    {
        $this->parameterHandler = new ContentType();
    }

    /**
     * @covers \Netgen\BlockManager\Ez\Parameters\FormMapper\ParameterHandler\ContentType::getFormType
     */
    public function testGetFormType()
    {
        self::assertEquals(ContentTypeType::class, $this->parameterHandler->getFormType());
    }

    /**
     * @covers \Netgen\BlockManager\Ez\Parameters\FormMapper\ParameterHandler\ContentType::convertOptions
     */
    public function testConvertOptions()
    {
        self::assertEquals(
            array(
                'multiple' => true,
            ),
            $this->parameterHandler->convertOptions(
                new ContentTypeParameter(array('multiple' => true))
            )
        );
    }
}