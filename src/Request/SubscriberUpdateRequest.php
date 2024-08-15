<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class SubscriberUpdateRequest extends AbstractReferencedBearerTransactionRequest
{
    use AuthorizationTrait;

    public function __construct(
        string $subscriberRef,
        string $reference,
        int $amount,
        string $bearer,
        string $validityDate
    ) {
        parent::__construct($reference, $amount, $bearer, $validityDate, $subscriberRef);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestType(): int
    {
        return RequestInterface::SUBSCRIBER_UPDATE;
    }
}
