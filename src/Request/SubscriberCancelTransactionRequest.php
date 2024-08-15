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
final class SubscriberCancelTransactionRequest extends AbstractReferencedBearerTransactionRequest
{
    use TransactionNumberTrait, CallNumberTrait;

    public function __construct(
        string $subscriberRef,
        string $reference,
        int $amount,
        string $bearer,
        string $validityDate,
        int $transactionNumber,
        int $callNumber
    ) {
        parent::__construct($reference, $amount, $bearer, $validityDate, $subscriberRef);

        $this->transactionNumber = $transactionNumber;
        $this->callNumber = $callNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestType(): int
    {
        return RequestInterface::SUBSCRIBER_CANCEL_TRANSACTION;
    }
}
