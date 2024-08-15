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

use function array_merge;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeAndCaptureRequest extends AbstractReferencedBearerTransactionRequest
{
    use AuthorizationTrait;
    use ID3DTrait;

    /**
     * {@inheritdoc}
     */
    public function getRequestType(): int
    {
        if ($this->hasSubscriberRef()) {
            return RequestInterface::SUBSCRIBER_AUTHORIZE_AND_CAPTURE;
        }

        return RequestInterface::AUTHORIZE_AND_CAPTURE;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters(): array
    {
        return array_merge(parent::getParameters(), $this->getID3DParameters());
    }
}
