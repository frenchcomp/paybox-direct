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
trait AuthorizationTrait
{
    /**
     * @Assert\Length(min=1, max=10)
     */
    private ?string $authorization = null;

    final public function setAuthorization(string $authorization = null): self
    {
        $this->authorization = $authorization;

        return $this;
    }

    final protected function hasAuthorization(): bool
    {
        return !empty($this->authorization);
    }

    final protected function getAuthorization(): ?string
    {
        return $this->authorization;
    }
}
