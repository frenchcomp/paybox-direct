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
use Nexy\PayboxDirect\Response\ResponseInterface;
use RuntimeException;

use function sprintf;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class PayboxException extends RuntimeException
{
    private ResponseInterface $response;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        ResponseInterface $response,
        ?Exception $previous = null
    ) {
        parent::__construct('', $response->getCode(), $previous);

        $this->message = sprintf('%05d: %s', $response->getCode(), $response->getComment());
        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
