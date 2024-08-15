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

use function array_key_exists;
use function array_map;
use function in_array;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractResponse implements ResponseInterface
{
    private int $code;

    private string $comment;

    private string $site;

    private string $rank;

    private int $callNumber;

    private int $questionNumber;

    private int $transactionNumber;

    /**
     * @var string|null|false
     */
    private $authorization;

    /**
     * @var string|null|false
     */
    private $country;

    /**
     * @var string|null|false
     */
    private $sha1;

    /**
     * @var string|null|false
     */
    private $cardType;

    private array $content;

    protected array $filteredParameters;

    /**
     * @param string[] $parameters
     */
    public function __construct(array $parameters)
    {
        $this->content = $parameters;
        // Cleanup array to set false for empty/invalid values.
        $this->filteredParameters = array_map(
            static function ($value) {
                if (in_array($value, ['', '???'], true)) {
                    return false;
                }

                return $value;
            },
            $parameters
        );

        $this->code = (int) $this->filteredParameters['CODEREPONSE'];
        $this->comment = $this->filteredParameters['COMMENTAIRE'];
        $this->site = $this->filteredParameters['SITE'];
        $this->rank = $this->filteredParameters['RANG'];
        $this->callNumber = (int) $this->filteredParameters['NUMAPPEL'];
        $this->questionNumber = (int) $this->filteredParameters['NUMQUESTION'];
        $this->transactionNumber = (int) $this->filteredParameters['NUMTRANS'];

        if (array_key_exists('AUTORISATION', $this->filteredParameters)) {
            $this->authorization = $this->filteredParameters['AUTORISATION'];
        }
        if (array_key_exists('PAYS', $this->filteredParameters)) {
            $this->country = $this->filteredParameters['PAYS'];
        }
        if (array_key_exists('SHA-1', $this->filteredParameters)) {
            $this->sha1 = $this->filteredParameters['SHA-1'];
        }
        if (array_key_exists('TYPECARTE', $this->filteredParameters)) {
            $this->cardType = $this->filteredParameters['TYPECARTE'];
        }
    }

    /**
     * {@inheritdoc}
     */
    final public function isSuccessful(): bool
    {
        return 0 === $this->code;
    }

    /**
     * {@inheritdoc}
     */
    final public function getCode(): int
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    final public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * {@inheritdoc}
     */
    final public function getSite(): string
    {
        return $this->site;
    }

    /**
     * {@inheritdoc}
     */
    final public function getRank(): string
    {
        return $this->rank;
    }

    /**
     * {@inheritdoc}
     */
    final public function getCallNumber(): int
    {
        return $this->callNumber;
    }

    /**
     * {@inheritdoc}
     */
    final public function getQuestionNumber(): int
    {
        return $this->questionNumber;
    }

    /**
     * {@inheritdoc}
     */
    final public function getTransactionNumber(): int
    {
        return $this->transactionNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * {@inheritdoc}
     */
    final public function getSha1()
    {
        return $this->sha1;
    }

    /**
     * {@inheritdoc}
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * {@inheritdoc}
     */
    final public function getContent(): array
    {
        return $this->content;
    }
}
