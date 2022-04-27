<?php

namespace App\Validator;

use App\Validator\Service;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * ServiceValidator
 * 
 * @author facundo ariel pérez <facundo.ariel.perez@gmail.com>
 */
class ServiceValidator extends ConstraintValidator
{
    private $noPainting;

    /**
     * constructor
     *
     * @param array $bindNoPainting
     */
    public function __construct(array $bindNoPainting)
    {
        $this->noPainting = $bindNoPainting;
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
        if (!$constraint instanceof Service) 
        {
            throw new UnexpectedTypeException($constraint, Service::class);
        }

        // custom constraints should ignore null and empty values to allow
        // other constraints (NotBlank, NotNull, etc.) to take care of that
        if (null === $value || '' === $value) 
        {
            return;
        }
        
        $car = $value->getCar();
        $color = $car->getColor();

        if($color->getDescription() == $this->noPainting['color'])
        {
            foreach($value->getItems() as $item)
            {
                $service = $item->getService();

                if($service->getDescription() == $this->noPainting['service'])
                {
                    $this->context->buildViolation('service.not.allowed', [ '%service%' => $service->getDescription(), ])
                        ->addViolation();
                }
            }
        }
    }
}
