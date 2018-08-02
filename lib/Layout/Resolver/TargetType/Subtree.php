<?php

declare(strict_types=1);

namespace Netgen\BlockManager\Ez\Layout\Resolver\TargetType;

use eZ\Publish\API\Repository\Values\Content\Location as APILocation;
use Netgen\BlockManager\Ez\ContentProvider\ContentExtractorInterface;
use Netgen\BlockManager\Ez\Validator\Constraint as EzConstraints;
use Netgen\BlockManager\Layout\Resolver\TargetTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;

final class Subtree implements TargetTypeInterface
{
    /**
     * @var \Netgen\BlockManager\Ez\ContentProvider\ContentExtractorInterface
     */
    private $contentExtractor;

    public function __construct(ContentExtractorInterface $contentExtractor)
    {
        $this->contentExtractor = $contentExtractor;
    }

    public static function getType(): string
    {
        return 'ezsubtree';
    }

    public function getConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Type(['type' => 'numeric']),
            new Constraints\GreaterThan(['value' => 0]),
            new EzConstraints\Location(),
        ];
    }

    public function provideValue(Request $request)
    {
        $location = $this->contentExtractor->extractLocation($request);

        return $location instanceof APILocation ? $location->path : null;
    }
}
