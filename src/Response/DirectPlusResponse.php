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

use RuntimeException;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class DirectPlusResponse extends AbstractResponse
{
    private string $subscriberRef;

    /**
     * @var string|false false if empty
     */
    private $bearer;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $parameters)
    {
        parent::__construct($parameters);

        if (isset($this->filteredParameters['REFABONNE'])) {
            $this->subscriberRef = $this->filteredParameters['REFABONNE'];
        }

        if (isset($this->filteredParameters['REFABONNE'])) {
            $this->bearer = $this->filteredParameters['PORTEUR'];
        }
    }

    public function getSubscriberRef(): string
    {
        return $this->subscriberRef;
    }

    public function getBearer(): string
    {
        return $this->bearer;
    }
}
