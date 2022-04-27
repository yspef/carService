<?php

namespace App\Validator;

use App\Validator\CarYear;
use DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * CarYearValidator
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
class CarYearValidator extends ConstraintValidator
{
    private $carYearFrom;

    /**
     * constructor
     *
     * @param integer $bindCarYearFrom
     */
    public function __construct(int $bindCarYearFrom)
    {
        $this->carYearFrom = $bindCarYearFrom;
    }

    /**
     * validate
     *
     * @param [type] $value
     * @param Constraint $constraint
     * @return void
     */
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
            $this->context->buildViolation($constraint->message, [ '%from%' => $this->carYearFrom, '%to%' => $to,])
                ->addViolation();
        }
    }
}
