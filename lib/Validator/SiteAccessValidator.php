<?php

declare(strict_types=1);

namespace Netgen\BlockManager\Ez\Validator;

use Netgen\BlockManager\Ez\Validator\Constraint\SiteAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Validates if the provided value is a valid eZ Platform siteaccess.
 */
final class SiteAccessValidator extends ConstraintValidator
{
    /**
     * @var array
     */
    private $siteAccessList;

    public function __construct(array $siteAccessList)
    {
        $this->siteAccessList = $siteAccessList;
    }

    public function validate($value, Constraint $constraint)
    {
        if ($value === null) {
            return;
        }

        if (!$constraint instanceof SiteAccess) {
            throw new UnexpectedTypeException($constraint, SiteAccess::class);
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if (!in_array($value, $this->siteAccessList, true)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%siteAccess%', $value)
                ->addViolation();
        }
    }
}
