<?php

namespace Netgen\BlockManager\Ez\Validator;

use Netgen\BlockManager\Ez\Validator\Constraint\SiteAccessGroup;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class SiteAccessGroupValidator extends ConstraintValidator
{
    /**
     * @var array
     */
    protected $siteAccessGroupList;

    /**
     * Constructor.
     *
     * @param array $siteAccessGroupList
     */
    public function __construct(array $siteAccessGroupList)
    {
        $this->siteAccessGroupList = array_keys($siteAccessGroupList);
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param \Symfony\Component\Validator\Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value === null) {
            return;
        }

        if (!$constraint instanceof SiteAccessGroup) {
            throw new UnexpectedTypeException($constraint, SiteAccessGroup::class);
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if (!in_array($value, $this->siteAccessGroupList, true)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%siteAccessGroup%', $value)
                ->addViolation();
        }
    }
}