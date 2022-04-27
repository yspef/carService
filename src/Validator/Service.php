<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Service extends Constraint
{
    public $message = 'service.not.allowed';

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
