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

use Symfony\Component\Validator\Constraints as Assert;

use function array_merge;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractReferencedTransactionRequest extends AbstractTransactionRequest
{
    /**
     * @Assert\Type("string")
     * @Assert\Length(min=1, max=250)
     */
    private string $reference;

    public function __construct(
        string $reference,
        int $amount,
        string $subscriberRef = null
    ) {
        parent::__construct($amount, $subscriberRef);

        $this->reference = $reference;
    }

    public function getParameters(): array
    {
        $parameters = [
            'REFERENCE' => $this->reference,
        ];

        return array_merge(parent::getParameters(), $parameters);
    }
}
