<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Exception;

use Exception;
use LogicException;
use Nexy\PayboxDirect\Request\RequestInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class InvalidRequestPropertiesException extends LogicException
{
    private ConstraintViolationListInterface $errors;

    public function __construct(
        RequestInterface $request,
        ConstraintViolationListInterface $errors,
        ?Exception $previous = null
    ) {
        parent::__construct('', 0, $previous);

        $this->message = PHP_EOL . $errors;
        $this->errors = $errors;
    }

    public function getErrors(): ConstraintViolationListInterface
    {
        return $this->errors;
    }
}
