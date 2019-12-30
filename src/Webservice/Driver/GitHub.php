<?php
declare(strict_types=1);

namespace App\Webservice\Driver;

use Cake\Http\Client;
use Muffin\Webservice\Webservice\Driver\AbstractDriver;

/**
 * Class GitHub
 *
 * @method \Cake\Http\Client client() client(Client $client = null)
 *
 * @package CvoTechnologies\GitHub\Webservice\Driver
 */
class GitHub extends AbstractDriver
{
    /**
     * {@inheritDoc}
     */
    public function initialize(): void
    {
        $this->client(new Client([
            'host' => 'api.github.com',
            'scheme' => 'https',
        ]));
    }
}
