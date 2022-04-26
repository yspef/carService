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
        //     // // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
        //     // throw new UnexpectedValueException($value, 'string');

        //     // separate multiple types using pipes
        //     // throw new UnexpectedValueException($value, 'string|int');
        // }

        // // access your configuration options like this:
        // if ('strict' === $constraint->mode) {
        //     // ...
        // }

        // if (!preg_match('/^[a-zA-Z0-9]+$/', $value, $matches)) {
            // the argument must be a string or an object implementing __toString()

            $msg = $this->translator->trans($constraint->message, [ '%from%' => $this->carYearFrom, '%to%' => $to,]);

            $this->context->buildViolation($msg)
                // ->setParameter('hola', $value)
                ->addViolation();
        }
    }
}
