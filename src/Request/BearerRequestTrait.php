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

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
trait BearerRequestTrait
{
    /**
     * Card number or reference.
     *
     * @Assert\Type("string")
     * @Assert\Length(min=1, max=19)
     */
    private string $bearer;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=4, max=4)
     * @Assert\Regex("/[0-9]+/")
     */
    private string $validityDate;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=3, max=4)
     * @Assert\Regex("/[0-9]+/")
     */
    private ?string $cardVerificationValue = null;

    public function setCardVerificationValue(string $cardVerificationValue = null): self
    {
        $this->cardVerificationValue = $cardVerificationValue;

        return $this;
    }

    private function getBearerParameters(): array
    {
        $parameters = [
            'PORTEUR' => $this->bearer,
            'DATEVAL' => $this->validityDate,
        ];

        if (null !== $this->cardVerificationValue) {
            $parameters['CVV'] = $this->cardVerificationValue;
        }

        return $parameters;
    }
}
