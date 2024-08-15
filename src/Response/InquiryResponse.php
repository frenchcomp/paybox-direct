<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Response;

use function array_key_exists;

/**
 * Special response for inquiry request.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class InquiryResponse extends AbstractResponse
{
    private string $status;


    private ?string $discount = null;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $parameters)
    {
        parent::__construct($parameters);

        $this->status = $this->filteredParameters['STATUS'];

        if (array_key_exists('REMISE', $this->filteredParameters)) {
            $this->discount = $this->filteredParameters['REMISE'];
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }
}
