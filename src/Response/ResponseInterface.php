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

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
interface ResponseInterface
{
    /**
     * Tells if response is successful based on `CODEREPONSE` parameter.
     */
    public function isSuccessful(): bool;

    /**
     * Corresponding to `CODEREPONSE`.
     */
    public function getCode(): int;

    /**
     * Corresponding to `COMMENTAIRE`.
     */
    public function getComment(): string;

    /**
     * Corresponding to `SITE`.
     */
    public function getSite(): string;

    /**
     * Corresponding to `RANG`.
     */
    public function getRank(): string;

    /**
     * Corresponding to `NUMAPPEL`.
     */
    public function getCallNumber(): int;

    /**
     * Corresponding to `NUMQUESTION`.
     */
    public function getQuestionNumber(): int;

    /**
     * Corresponding to `NUMTRANS`.
     */
    public function getTransactionNumber(): int;

    /**
     * Corresponding to `AUTORISATION`.
     *
     * @return string|null|false null if not provided, false if empty
     */
    public function getAuthorization();

    /**
     * Corresponding to `PAYS`.
     *
     * @return string|null|false null if not requested, false if '???' or empty string returned by Paybox
     */
    public function getCountry();

    /**
     * Corresponding to `SHA-1`.
     *
     * @return string|null|false null if not requested, false if empty string returned by Paybox
     */
    public function getSha1();

    /**
     * Corresponding to `TYPECARTE`.
     *
     * @return string|null|false null if not requested, false if empty string returned by Paybox
     */
    public function getCardType();

    /**
     * Get response content
     */
    public function getContent(): array;
}
