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
final class AuthorizeAndCaptureRequest extends AbstractReferencedBearerTransactionRequest
{
    use AuthorizationTrait;
    use ID3DTrait;

    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return $this->hasSubscriberRef()
            ? RequestInterface::SUBSCRIBER_AUTHORIZE_AND_CAPTURE
            : RequestInterface::AUTHORIZE_AND_CAPTURE
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return array_merge(parent::getParameters(), $this->getID3DParameters());
    }
}
