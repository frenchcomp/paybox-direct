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

use GuzzleHttp\Client;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class GuzzleHttpClient extends AbstractHttpClient
{
    private Client $client;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        $this->client = new Client(
            [
                'base_uri' => $this->baseUrl,
                'timeout' => $this->timeout,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function request(array $parameters): string
    {
        $response = $this->client->post('', [
            'form_params' => $parameters,
        ]);

        return (string) $response->getBody();
    }
}
