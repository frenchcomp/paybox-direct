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
final class SubscriberRegisterRequest extends AbstractReferencedBearerTransactionRequest
{
    use AuthorizationTrait;
    use ID3DTrait;

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
        return RequestInterface::SUBSCRIBER_REGISTER;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters(): array
    {
        return array_merge(parent::getParameters(), $this->getID3DParameters());
    }
}
