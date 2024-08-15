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

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
interface RequestInterface
{
    public const AUTHORIZE = 1;

    public const DEBIT = 2;

    public const AUTHORIZE_AND_CAPTURE = 3;

    public const CREDIT = 4;

    public const CANCEL = 5;

    public const CHECK = 11;

    public const TRANSACT = 12;

    public const UPDATE_AMOUNT = 13;

    public const REFUND = 14;

    public const INQUIRY = 17;

    public const SUBSCRIBER_AUTHORIZE = 51;

    public const SUBSCRIBER_DEBIT = 52;

    public const SUBSCRIBER_AUTHORIZE_AND_CAPTURE = 53;

    public const SUBSCRIBER_CREDIT = 54;

    public const SUBSCRIBER_CANCEL_TRANSACTION = 55;

    public const SUBSCRIBER_REGISTER = 56;

    public const SUBSCRIBER_UPDATE = 57;

    public const SUBSCRIBER_DELETE = 58;

    public const SUBSCRIBER_TRANSACT = 61;

    /**
     * Returns the request type.
     *
     * Corresponds to the TYPE parameters of PayBox.
     */
    public function getRequestType(): int;

    /**
     * Returns Paybox formatted parameters array.
     */
    public function getParameters(): array;
}
