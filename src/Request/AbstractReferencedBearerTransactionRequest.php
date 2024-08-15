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

use function array_merge;

/**
 * Requests with card numbers or reference.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractReferencedBearerTransactionRequest extends AbstractReferencedTransactionRequest
{
    use BearerRequestTrait;


    public function __construct(
        string $reference,
        int $amount,
        string $bearer,
        string $validityDate,
        string $subscriberRef = null
    ) {
        parent::__construct($reference, $amount, $subscriberRef);

        $this->bearer = $bearer;
        $this->validityDate = $validityDate;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters(): array
    {
        return array_merge(parent::getParameters(), $this->getBearerParameters());
    }
}
