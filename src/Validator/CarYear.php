<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CarYear extends Constraint
{
    public $message = 'incorrect.year.value';

    /**
     * validatedBy
     *
     * @return string
     */
    public function validatedBy(): string
    {
        $zval = static::class . 'Validator';

        return($zval);
    }
}
