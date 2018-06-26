<?php

declare(strict_types=1);

namespace Netgen\BlockManager\Ez\Validator;

use eZ\Publish\API\Repository\Exceptions\NotFoundException;
use eZ\Publish\API\Repository\Repository;
use eZ\Publish\API\Repository\Values\Content\Section as APISection;
use Netgen\BlockManager\Ez\Validator\Constraint\Section;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Validates if the provided value is an identifier of a valid section in eZ Platform.
 */
final class SectionValidator extends ConstraintValidator
{
    /**
     * @var \eZ\Publish\API\Repository\Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function validate($value, Constraint $constraint): void
    {
        if ($value === null) {
            return;
        }

        if (!$constraint instanceof Section) {
            throw new UnexpectedTypeException($constraint, Section::class);
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if (!is_array($constraint->allowedSections)) {
            throw new UnexpectedTypeException($constraint->allowedSections, 'array');
        }

        try {
            $this->repository->sudo(
                function (Repository $repository) use ($value): APISection {
                    return $repository->getSectionService()->loadSectionByIdentifier($value);
                }
            );
        } catch (NotFoundException $e) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%identifier%', $value)
                ->addViolation();

            return;
        }

        if (empty($constraint->allowedSections)) {
            return;
        }

        if (in_array($value, $constraint->allowedSections, true)) {
            return;
        }

        $this->context->buildViolation($constraint->notAllowedMessage)
            ->setParameter('%identifier%', $value)
            ->addViolation();
    }
}
