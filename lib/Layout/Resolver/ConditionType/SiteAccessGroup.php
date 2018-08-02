<?php

declare(strict_types=1);

namespace Netgen\BlockManager\Ez\Layout\Resolver\ConditionType;

use eZ\Publish\Core\MVC\Symfony\SiteAccess as EzPublishSiteAccess;
use Netgen\BlockManager\Ez\Validator\Constraint as EzConstraints;
use Netgen\BlockManager\Layout\Resolver\ConditionTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;

final class SiteAccessGroup implements ConditionTypeInterface
{
    /**
     * @var array
     */
    private $groupsBySiteAccess;

    public function __construct(array $groupsBySiteAccess)
    {
        $this->groupsBySiteAccess = $groupsBySiteAccess;
    }

    public static function getType(): string
    {
        return 'ez_site_access_group';
    }

    public function getConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Type(['type' => 'array']),
            new Constraints\All(
                [
                    'constraints' => [
                        new Constraints\Type(['type' => 'string']),
                        new EzConstraints\SiteAccessGroup(),
                    ],
                ]
            ),
        ];
    }

    public function matches(Request $request, $value): bool
    {
        $siteAccess = $request->attributes->get('siteaccess');
        if (!$siteAccess instanceof EzPublishSiteAccess) {
            return false;
        }

        if (!is_array($value) || empty($value)) {
            return false;
        }

        // We skip the check if siteaccess is not part of any group
        if (!isset($this->groupsBySiteAccess[$siteAccess->name])) {
            return false;
        }

        return !empty(array_intersect($value, $this->groupsBySiteAccess[$siteAccess->name]));
    }
}
