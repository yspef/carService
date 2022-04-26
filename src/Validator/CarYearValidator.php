<?php

namespace App\Validator;

use App\Validator\CarYear;
use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

// use Symfony\Component\Validator\Exception\UnexpectedValueException;

class CarYearValidator extends ConstraintValidator
{
    private $carYearFrom;
    private $translator;

    public function __construct(int $bindCarYearFrom, TranslatorInterface $translator)
    {
        $this->carYearFrom = $bindCarYearFrom;
        $this->translator = $translator;
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof CarYear) 
        {
            throw new UnexpectedTypeException($constraint, CarYear::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) 
        {
            return;
        }

        $now = new DateTime();
        $to = $now->format('Y');

        if($this->carYearFrom > $value || $to < $value)
        {
            $msg = $this->translator->trans($constraint->message, [ '%from%' => $this->carYearFrom, '%to%' => $to,]);

            $this->context->buildViolation($msg)
                ->addViolation();
        }
    }
}
