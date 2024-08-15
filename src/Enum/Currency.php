<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Enum;

use Greg0ire\Enum\AbstractEnum;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Currency extends AbstractEnum
{
    public const EURO = 978;

    public const US_DOLLAR = 840;

    public const CFA = 952;
}
