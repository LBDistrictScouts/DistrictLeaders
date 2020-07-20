<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Utility\GoogleBuilder;
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
     * Get Client for Google
     *
     * @return \Cake\Http\Response|\Google_Client
     */
    public function getClient()
    {
        $client = GoogleBuilder::newClient();

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = Configure::read('GoogleClient.TokenPath', 'config/Credentials/token.json');
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
     * @return \Google_Service_Directory
     * @throws \Google_Exception
     */
    public function getService()
    {
        $client = $this->getClient();
        return new Google_Service_Directory($client);
    }

    /**
     * Save Token Method
     *
     * @param \Google_Client $client An Activated Client
     * @return void
     */
    public function saveToken(Google_Client $client)
    {
        $tokenPath = Configure::read('GoogleClient.TokenPath', 'config/Credentials/token.json');

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
        $tokenPath = Configure::read('GoogleClient.TokenPath', 'config/Credentials/token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        return $client;
    }

    /**
     * get List
     *
     * @return \Google_Service_Directory_Users
     * @throws \Google_Exception
     */
    public function getList($domain = null)
    {
        $service = $this->getService();

        // Print the first 10 users in the domain.
        $optParams = [
            'customer' => 'my_customer',
            'domain' => $domain,
            'maxResults' => 50,
            'orderBy' => 'email',
        ];
        return $service->users->listUsers($optParams);
    }

    /**
     * get List
     *
     * @return \Google_Service_Directory_User
     * @throws \Google_Exception
     */
    public function getUser($userId)
    {
        $service = $this->getService();

        return $service->users->get($userId);
    }

    /**
     * get List
     *
     * @return \Google_Service_Directory_Domains2
     * @throws \Google_Exception
     */
    public function getDomainList()
    {
        $service = $this->getService();

        return $service->domains->listDomains('my_customer');
    }
}
