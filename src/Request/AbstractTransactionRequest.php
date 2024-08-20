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

use Greg0ire\Enum\Bridge\Symfony\Validator\Constraint\Enum;
use Symfony\Component\Validator\Constraints as Assert;

use function array_merge;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractTransactionRequest extends AbstractRequest
{
    /**
     * @Assert\Type("int")
     */
    private ?int $amount;

    /**
     * @Enum(class="Nexy\PayboxDirect\Enum\Currency", showKeys=true)
     */
    private ?int $currency = null;

    public function __construct(?int $amount, string $subscriberRef = null)
    {
        parent::__construct($subscriberRef);

        $this->amount = $amount;
    }

    final public function setCurrency(int $currency = null): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getParameters(): array
    {
        $parameters = [
            'MONTANT' => $this->amount,
            'DEVISE' => $this->currency,
        ];

        return array_merge(parent::getParameters(), $parameters);
    }
}
