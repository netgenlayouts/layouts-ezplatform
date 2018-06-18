<?php

declare(strict_types=1);

namespace Netgen\BlockManager\Ez\Tests\Layout\Resolver\Form\TargetType\Mapper;

use Netgen\BlockManager\Ez\Layout\Resolver\Form\TargetType\Mapper\SemanticPathInfoPrefix;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class SemanticPathInfoPrefixTest extends TestCase
{
    /**
     * @var \Netgen\BlockManager\Layout\Resolver\Form\TargetType\MapperInterface
     */
    private $mapper;

    public function setUp(): void
    {
        $this->mapper = new SemanticPathInfoPrefix();
    }

    /**
     * @covers \Netgen\BlockManager\Ez\Layout\Resolver\Form\TargetType\Mapper\SemanticPathInfoPrefix::getFormType
     */
    public function testGetFormType(): void
    {
        $this->assertSame(TextType::class, $this->mapper->getFormType());
    }
}
