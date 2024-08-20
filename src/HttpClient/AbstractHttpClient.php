<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\HttpClient;

use InvalidArgumentException;
use Nexy\PayboxDirect\Exception\PayboxException;
use Nexy\PayboxDirect\Paybox;
use Nexy\PayboxDirect\Response\ResponseInterface;

use function array_key_exists;
use function array_merge;
use function is_a;
use function parse_str;
use function random_int;

use function str_pad;

use function trim;
use function utf8_encode;

use const STR_PAD_LEFT;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @see http://www1.paybox.com/espace-integrateur-documentation/les-solutions-paybox-direct-et-paybox-direct-plus/
 */
abstract class AbstractHttpClient
{
    protected int $timeout;

    protected string $baseUrl = Paybox::API_URL_TEST;

    /**
     * @var string[]
     */
    private array $baseParameters;

    private int $defaultCurrency;

    private ?int $defaultActivity = null;

    private int $questionNumber;

    final public function __construct()
    {
        $this->questionNumber = random_int(1, '2147483647');
    }

    /**
     * @param array $options
     */
    final public function setOptions(array $options): void
    {
        $this->timeout = $options['timeout'];
        if (!empty($options['production'])) {
            $this->baseUrl = Paybox::API_URL_PRODUCTION;
        } else {
            $this->baseUrl = Paybox::API_URL_TEST;
        }

        $this->baseParameters = [
            'VERSION' => $options['paybox_version'],
            'SITE' => $options['paybox_site'],
            'RANG' => $options['paybox_rank'],
            'IDENTIFIANT' => $options['paybox_identifier'],
            'CLE' => $options['paybox_key'],
        ];

        $this->defaultCurrency = $options['paybox_default_currency'];

        if (array_key_exists('paybox_default_activity', $options)) {
            $this->defaultActivity = $options['paybox_default_activity'];
        }
    }

    /**
     * Calls PayBox Direct platform with given operation type and parameters.
     *
     * @param int      $type          Request type
     * @param string[] $parameters    Request parameters
     * @param string   $responseClass
     *
     * @return ResponseInterface The response content
     *
     * @throws PayboxException
     */
    final public function call(int $type, array $parameters, string $responseClass): ResponseInterface
    {
        if (!is_a($responseClass, ResponseInterface::class, true)) {
            throw new InvalidArgumentException('The response class must implement ' . ResponseInterface::class . '.');
        }

        $bodyParams = $this->getParameters($type, $parameters);
        $bodyParams['DATEQ'] = $parameters['DATEQ'] ?? date('dmYHis');

        $response = $this->request($bodyParams);
        $results = self::parseHttpResponse($response);

        $this->questionNumber = (int) $results['NUMQUESTION'] + 1;

        /** @var ResponseInterface $response */
        $response = new $responseClass($results);

        if (!$response->isSuccessful()) {
            throw new PayboxException($response);
        }

        return $response;
    }



    /**
     * Get parameters specified for request
     */
    public function getParameters(int $type, array $parameters): array
    {
        $bodyParams = array_merge($parameters, $this->baseParameters);

        $bodyParams['TYPE'] = $type;
        $bodyParams['NUMQUESTION'] = $this->questionNumber;

        $bodyParams['DATEQ'] = $parameters['DATEQ'] ?? date('dmYHis');

        // Restore default_currency from parameters if given
        if (array_key_exists('DEVISE', $parameters)) {
            $bodyParams['DEVISE'] = $parameters['DEVISE'] ?? $this->defaultCurrency;
        }
        if (!array_key_exists('ACTIVITE', $parameters) && $this->defaultActivity) {
            $bodyParams['ACTIVITE'] = $this->defaultActivity;
        }

        // `ACTIVITE` must be a string of 3 numbers to get it working with Paybox API.
        if (array_key_exists('ACTIVITE', $bodyParams)) {
            $bodyParams['ACTIVITE'] = str_pad($bodyParams['ACTIVITE'], 3, '0', STR_PAD_LEFT);
        }

        return $bodyParams;
    }

    /**
     * Generate results array from HTTP response body
     * @todo must be private and static
     */
    public static function parseHttpResponse(string $response): array
    {
        parse_str($response, $results);
        foreach ($results as &$value) {
            $value = utf8_encode(trim($value));
        }

        return $results;
    }

    /**
     * Init and setup http client with PayboxDirectPlus SDK options.
     */
    abstract public function init();

    /**
     * Sends a request to the server, receive a response and returns it as a string.
     *
     * @param string[] $parameters Request parameters
     */
    abstract protected function request(array $parameters): string;
}
