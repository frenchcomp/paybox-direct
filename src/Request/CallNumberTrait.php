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
trait CallNumberTrait
{
    /**
     * @Assert\Type("int")
     * @Assert\Length(max=10)
     */
    private int $callNumber;

    final protected function getCallNumber(): int
    {
        return $this->callNumber;
    }
}
