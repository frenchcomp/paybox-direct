<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Nexy\PayboxDirect\Enum\Activity;
use Nexy\PayboxDirect\Enum\Currency;
use Nexy\PayboxDirect\Enum\Version;
use Nexy\PayboxDirect\Exception\InvalidRequestPropertiesException;
use Nexy\PayboxDirect\HttpClient\AbstractHttpClient;
use Nexy\PayboxDirect\HttpClient\GuzzleHttpClient;
use Nexy\PayboxDirect\Request\InquiryRequest;
use Nexy\PayboxDirect\Request\RequestInterface;
use Nexy\PayboxDirect\Response\DirectPlusResponse;
use Nexy\PayboxDirect\Response\DirectResponse;
use Nexy\PayboxDirect\Response\InquiryResponse;
use Nexy\PayboxDirect\Response\ResponseInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 *
 * @see http://www1.paybox.com/espace-integrateur-documentation/les-solutions-paybox-direct-et-paybox-direct-plus/les-operations-de-caisse-direct-plus/
 * @see http://www1.paybox.com/espace-integrateur-documentation/dictionnaire-des-donnees/paybox-direct-et-direct-plus/
 */
class Paybox
{
    const API_URL_PRODUCTION = 'https://ppps.paybox.com/PPPS.php';
    const API_URL_RESCUE = 'https://ppps1.paybox.com/PPPS.php';
    const API_URL_TEST = 'https://preprod-ppps.paybox.com/PPPS.php';

    const URL_3DS_PRODUCTION = 'https://tpeweb.paybox.com/cgi/RemoteMPI.cgi';
    const URL_3DS_RESCUE = 'https://tpeweb1.paybox.com/cgi/RemoteMPI.cgi';
    const URL_3DS_TEST = 'https://preprod-tpeweb.paybox.com/cgi/RemoteMPI.cgi';

    const INVALID_CREDENTIALS_MESSAGE = 'Paybox SDK: invalid change of credentials';

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var AbstractHttpClient
     */
    private $httpClient;

    /**
     * @var array
     */
    private $options;

    public function __construct(array $options = [], AbstractHttpClient $httpClient = null)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);

        AnnotationRegistry::registerLoader('class_exists');
        $this->validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        $this->httpClient = $httpClient ? $httpClient : new GuzzleHttpClient();
        $this->httpClient->setOptions($this->options);
        $this->httpClient->init();
    }

    /**
     * @param RequestInterface $request
     *
     * @return DirectResponse
     */
    public function sendDirectRequest(RequestInterface $request)
    {
        if ($request->getRequestType() >= RequestInterface::SUBSCRIBER_AUTHORIZE) {
            throw new \InvalidArgumentException(
                'Direct Plus requests must be passed onto '.__CLASS__.'::sendDirectPlusRequest method.'
            );
        }
        if ($request instanceof InquiryRequest) {
            throw new \InvalidArgumentException(
                'Inquiry requests must be passed onto '.__CLASS__.'::sendInquiryRequest method.'
            );
        }

        return $this->request($request);
    }

    /**
     * @param RequestInterface $request
     *
     * @return DirectPlusResponse
     */
    public function sendDirectPlusRequest(RequestInterface $request)
    {
        if ($request->getRequestType() < RequestInterface::SUBSCRIBER_AUTHORIZE) {
            throw new \InvalidArgumentException(
                'Direct requests must be passed onto '.__CLASS__.'::sendDirectRequest method.'
            );
        }

        return $this->request($request, DirectPlusResponse::class);
    }

    /**
     * @param InquiryRequest $request
     *
     * @return InquiryResponse
     */
    public function sendInquiryRequest(InquiryRequest $request)
    {
        return $this->request($request, InquiryResponse::class);
    }

    /**
     * @param RequestInterface $request
     * @param string           $responseClass
     *
     * @return ResponseInterface
     *
     * @throws Exception\InvalidRequestPropertiesException
     * @throws Exception\PayboxException
     */
    private function request(RequestInterface $request, $responseClass = DirectResponse::class)
    {
        $errors = $this->validator->validate($request);
        if ($errors->count() > 0) {
            throw new InvalidRequestPropertiesException($request, $errors);
        }

        return $this->httpClient->call($request->getRequestType(), $request->getParameters(), $responseClass);
    }

    /**
     * Paybox base options validation.
     *
     * @param OptionsResolver $resolver
     */
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'timeout' => 10,
            'production' => false,
            'paybox_default_currency' => Currency::EURO,
        ]);
        $resolver->setDefined([
            'paybox_default_activity',
        ]);
        $resolver->setRequired([
            'paybox_version', // Paybox Direct Plus protocol
            'paybox_site',
            'paybox_rank',
            'paybox_identifier',
            'paybox_key',
        ]);

        $resolver->setAllowedTypes('timeout', 'int');
        $resolver->setAllowedTypes('production', 'bool');
        $resolver->setAllowedTypes('paybox_version', 'string');
        $resolver->setAllowedTypes('paybox_default_currency', 'int');
        $resolver->setAllowedTypes('paybox_site', 'string');
        $resolver->setAllowedTypes('paybox_rank', 'string');
        $resolver->setAllowedTypes('paybox_identifier', 'string');
        $resolver->setAllowedTypes('paybox_key', 'string');

        $resolver->setAllowedValues('paybox_version', Version::getConstants());
        $resolver->setAllowedValues('paybox_default_activity', Activity::getConstants());
    }

    /**
     * @param string      $site
     * @param string      $rank
     * @param string      $identifier
     * @param string      $key
     * @param string|null $version
     * @return void
     * @throws \Exception
     */
    public function setCredentials($site, $rank, $identifier, $key, $version = null)
    {
        if (!isset($site) || !isset($rank) || !isset($identifier) || !isset($key)) {
            throw new \Exception(self::INVALID_CREDENTIALS_MESSAGE);
        }
        $this->options['paybox_site'] = $site;
        $this->options['paybox_rank'] = $rank;
        $this->options['paybox_identifier'] = $identifier;
        $this->options['paybox_key'] = $key;
        if (isset($version)) {
            $version = strtoupper($version);
            $allowedVersions = Version::getConstants();
            if (!isset($allowedVersions[$version])) {
                throw new \Exception(self::INVALID_CREDENTIALS_MESSAGE);
            }
            $this->options['paybox_version'] = $allowedVersions[$version];
        }

        $this->httpClient->setOptions($this->options);
    }

    /**
     * Get parameters that have been set for passed request object
     *
     * @param RequestInterface $request
     * @return array
     */
    public function getParametersSet(RequestInterface $request)
    {
        return $this->httpClient->getParameters($request->getRequestType(), $request->getParameters());
    }

    /**
     * Get 3DSecure URL for specified environment
     *
     * @return string
     */
    public function get3dsUrl()
    {
        return true === $this->options['production'] ? self::URL_3DS_PRODUCTION : self::URL_3DS_TEST;
    }
}
