<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Google_Client;
use Google_Service_Directory;

/**
 * GoogleClient component
 */
class GoogleClientComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * Private Google Client Builder
     *
     * @throws \Google_Exception
     * @return \Google_Client
     */
    public function newClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('G Suite Directory API PHP Quickstart');
        $client->setScopes(Google_Service_Directory::ADMIN_DIRECTORY_USER_READONLY);
        $client->setAuthConfig('config/credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        return $client;
    }

    /**
     * Get Client for Google
     *
     * @return \Cake\Http\Response|\Google_Client
     * @throws \Google_Exception
     */
    public function getClient()
    {
        $client = $this->newClient();

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = Configure::read('GoogleClient.TokenPath', 'config/token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                return $this->_registry->getController()->redirect([
                    'controller' => 'admin',
                    'action' => 'google',
                ]);
            }
            $this->saveToken($client);
        }

        return $client;
    }

    /**
     * Save Token Method
     *
     * @param \Google_Client $client An Activated Client
     * @return void
     */
    public function saveToken(Google_Client $client)
    {
        $tokenPath = Configure::read('GoogleClient.TokenPath', 'config/token.json');

        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }

    /**
     * @param \Google_Client $client The Google Token to get Token
     * @return \Google_Client
     */
    public function getToken(Google_Client $client)
    {
        $tokenPath = Configure::read('GoogleClient.TokenPath', 'config/token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        return $client;
    }

    /**
     * get List
     *
     * @return array
     * @throws \Google_Exception
     */
    public function getList()
    {
        // Get the API client and construct the service object.
        $client = $this->getClient();
        $service = new Google_Service_Directory($client);

        // Print the first 10 users in the domain.
        $optParams = [
            'customer' => 'my_customer',
            'maxResults' => 10,
            'orderBy' => 'email',
        ];
        $results = $service->users->listUsers($optParams);

        if (count($results->getUsers()) == 0) {
            return [];
        } else {
            return $results->getUsers()->toSimpleObject();
        }
    }
}
