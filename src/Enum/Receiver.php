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
 * Enum for `ACQUEREUR`.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Receiver extends AbstractEnum
{
    public const PAYPAL = 'PAYPAL';

    public const EMS = 'EMS';

    public const ATOSBE = 'ATOSBE';

    public const BCMC = 'BCMC';

    public const PSC = 'PSC';

    public const FINAREF = 'FINAREF';

    public const BUYSTER = 'BUYSTER';

    public const ONEY = '34ONEY';
}
