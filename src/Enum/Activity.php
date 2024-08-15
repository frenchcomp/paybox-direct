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
final class Activity extends AbstractEnum
{
    public const NOT_SPECIFIED = 20;

    public const PHONE_REQUEST = 21;

    public const MAIL_REQUEST = 22;

    public const MINITEL_REQUEST = 23;

    public const WEB_REQUEST = 24;

    public const RECURRING_PAYMENT = 27;
}
