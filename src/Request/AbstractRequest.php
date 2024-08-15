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

use DateTime;
use Greg0ire\Enum\Bridge\Symfony\Validator\Constraint\Enum;
use Symfony\Component\Validator\Constraints as Assert;

use function method_exists;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractRequest implements RequestInterface
{
    /**
     * @Enum(class="Nexy\PayboxDirect\Enum\Activity", showKeys=true)
     */
    private ?int $activity = null;

    /**
     * @Assert\Type("\DateTime")
     */
    private ?DateTime $date = null;

    /**
     * @Assert\Type("bool")
     */
    private bool $showCountry = false;

    /**
     * @Assert\Type("bool")
     */
    private bool $showSha1 = false;

    /**
     * @Assert\Type("bool")
     */
    private bool $showCardType = false;

    /**
     * @Assert\Type("string")
     * @Assert\Length(min=1, max=250)
     */
    private ?string $subscriberRef = null;

    public function __construct(string $subscriberRef = null)
    {
        $this->subscriberRef = $subscriberRef;
    }

    final public function setActivity(int $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

    final public function setDate(DateTime $date = null): self
    {
        $this->date = $date;

        return $this;
    }

    final public function setShowCountry(bool $showCountry): self
    {
        $this->showCountry = $showCountry;

        return $this;
    }


    final public function setShowSha1(bool $showSha1): self
    {
        $this->showSha1 = $showSha1;

        return $this;
    }

    final public function setShowCardType(bool $showCardType): self
    {
        $this->showCardType = $showCardType;

        return $this;
    }

    final protected function hasSubscriberRef(): bool
    {
        return !empty($this->subscriberRef);
    }

    final protected function getSubscriberRef(): ?string
    {
        return $this->subscriberRef;
    }

    public function getParameters(): array
    {
        $parameters = ['DATEQ' => null];

        if ($this->date instanceof DateTime) {
            $parameters['DATEQ'] = $this->date->format('dmYHis');
        }

        if ($this->activity) {
            $parameters['ACTIVITE'] = $this->activity;
        }
        if ($this->showCountry) {
            $parameters['PAYS'] = '';
        }
        if ($this->showSha1) {
            $parameters['SHA-1'] = '';
        }
        if ($this->showCardType) {
            $parameters['TYPECARTE'] = '';
        }

        if (method_exists($this, 'getTransactionNumber')) {
            $parameters['NUMTRANS'] = $this->getTransactionNumber();
        }
        if (method_exists($this, 'getCallNumber')) {
            $parameters['NUMAPPEL'] = $this->getCallNumber();
        }
        if (
            method_exists($this, 'getAuthorization')
            && method_exists($this, 'hasAuthorization')
            && $this->hasAuthorization()
        ) {
            $parameters['AUTORISATION'] = $this->getAuthorization();
        }

        // Direct Plus requests special case.
        if ($this->hasSubscriberRef()) {
            $parameters['REFABONNE'] = $this->getSubscriberRef();
        }

        return $parameters;
    }
}
