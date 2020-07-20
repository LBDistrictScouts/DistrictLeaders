<?php
declare(strict_types=1);

namespace App\Utility;

use App\Model\Entity\Directory;
use Cake\Core\Configure;
use Google_Client;
use Google_Service_Directory;

/**
 * GoogleClient component
 */
class GoogleBuilder
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public static function newClient(Directory $directory = null): Google_Client
    {
        $client = new Google_Client();
        $client->setApplicationName(Configure::read('App.who.system', 'District Leaders System'));
        $client->setScopes([
            Google_Service_Directory::ADMIN_DIRECTORY_DOMAIN_READONLY,
            Google_Service_Directory::ADMIN_DIRECTORY_USER,
            Google_Service_Directory::ADMIN_DIRECTORY_GROUP,
        ]);
        if (is_null($directory)) {
            try {
                $client->setAuthConfig($directory->get(Directory::FIELD_CONFIGURATION_PAYLOAD));
            } catch (\Google_Exception $e) {
                $client->setAuthConfig('config/Credentials/credentials.json');
            }
        } else {
            $client->setAuthConfig('config/Credentials/credentials.json');
        }

        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
    }

    /**
     * Get Client for Google
     *
     * @param \App\Model\Entity\Directory|null $directory
     *
     * @return \Google_Client|false
     */
    public static function getClient(Directory $directory = null)
    {
        $client = GoogleBuilder::newClient($directory);

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
                return false;
            }
            GoogleBuilder::saveToken($client);
        }

        return $client;
    }

    /**
     * @return \Google_Service_Directory
     * @throws \Google_Exception
     */
    public function getService()
    {
        $client = GoogleBuilder::getClient();
        return new Google_Service_Directory($client);
    }

    /**
     * Save Token Method
     *
     * @param \Google_Client $client An Activated Client
     * @return void
     */
    public static function saveToken(Google_Client $client)
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
