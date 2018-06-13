<?php

declare(strict_types=1);

namespace Netgen\BlockManager\Ez\Tests\Validator\Constraint;

use Netgen\BlockManager\Ez\Validator\Constraint\Tag;
use PHPUnit\Framework\TestCase;

final class TagTest extends TestCase
{
    /**
     * @covers \Netgen\BlockManager\Ez\Validator\Constraint\Tag::validatedBy
     */
    public function testValidatedBy()
    {
        $constraint = new Tag();
        $this->assertEquals('ngbm_eztags', $constraint->validatedBy());
    }
}
