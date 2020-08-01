<?php
declare(strict_types=1);

namespace App\Utility;

use App\Model\Entity\Directory;
use Cake\Core\Configure;
use Cake\Datasource\FactoryLocator;
use Cake\ORM\Locator\LocatorAwareTrait;
use Google_Client;
use Google_Service_Directory;
use Google_Service_Directory_Groups;

/**
 * GoogleClient component
 */
class GoogleBuilder
{
    use LocatorAwareTrait;

    protected const ACCESS_TYPE = 'offline';

    protected const ACCESS_PROMPT = 'select_account consent';

    /**
     * @return \Google_Client
     * @throws \Google_Exception
     */
    public static function newClient(): Google_Client
    {
        $client = new Google_Client();
        $client->setApplicationName(Configure::read('App.who.system', 'District Leaders System'));
        $client->setScopes([
            Google_Service_Directory::ADMIN_DIRECTORY_DOMAIN_READONLY,
            Google_Service_Directory::ADMIN_DIRECTORY_USER,
            Google_Service_Directory::ADMIN_DIRECTORY_GROUP,
        ]);
        $client->setAuthConfig(Configure::read('GoogleClient.TokenPath', 'config/Credentials/credentials.json'));
        $client->setAccessType(GoogleBuilder::ACCESS_TYPE);
        $client->setPrompt(GoogleBuilder::ACCESS_PROMPT);

        return $client;
    }

    /**
     * Get Client for Google
     *
     * @param \App\Model\Entity\Directory|null $directory The Directory to Take Config From
     * @return \Google_Client|false
     * @throws \Google_Exception
     */
    public static function getClient(?Directory $directory = null)
    {
        $client = GoogleBuilder::newClient();

        $client = GoogleBuilder::getToken($client, $directory);

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                return false;
            }
            GoogleBuilder::saveToken($client, $directory);
        }

        return $client;
    }

    /**
     * @param \App\Model\Entity\Directory|null $directory The Directory to Take Config From
     * @return \Google_Service_Directory
     * @throws \Google_Exception
     */
    public static function getService(?Directory $directory = null)
    {
        $client = GoogleBuilder::getClient($directory);

        return new Google_Service_Directory($client);
    }

    /**
     * Save Token Method
     *
     * @param \Google_Client $client An Activated Client
     * @param \App\Model\Entity\Directory|null $directory The Directory to Save Config To
     * @return void
     */
    public static function saveToken(Google_Client $client, ?Directory $directory = null)
    {
        if ($directory instanceof Directory) {
            $directory->set(Directory::FIELD_AUTHORISATION_TOKEN, $client->getAccessToken());

            $directories = FactoryLocator::get('Table')->get('Directories');
            $directories->save($directory, ['validator' => false]);

            return;
        }
    }

    /**
     * @param \Google_Client $client The Google Token to get Token
     * @param \App\Model\Entity\Directory|null $directory The Directory to Take Config From
     * @return \Google_Client
     */
    public static function getToken(Google_Client $client, ?Directory $directory = null)
    {
        if ($directory instanceof Directory && $directory->has(Directory::FIELD_AUTHORISATION_TOKEN)) {
            $accessToken = $directory->get(Directory::FIELD_AUTHORISATION_TOKEN);
            $client->setAccessToken($accessToken);

            return $client;
        }

        return $client;
    }

    /**
     * get List
     *
     * @param \App\Model\Entity\Directory|null $directory The Directory to Take Config From
     * @param null $domain Domain Limit
     * @param int $limit Page Size
     * @param string|null $pageToken String for Next Result Set
     * @return \Google_Service_Directory_Users
     * @throws \Google_Exception
     */
    public static function getUserList(
        ?Directory $directory = null,
        $domain = null,
        int $limit = 50,
        ?string $pageToken = null
    ) {
        $service = GoogleBuilder::getService($directory);

        $customerReference = 'my_customer';
        if (!empty($directory->customer_reference)) {
            $customerReference = $directory->customer_reference;
        }

        $optParams = [
            'customer' => $customerReference,
            'maxResults' => $limit,
            'orderBy' => 'email',
        ];

        if (!is_null($pageToken)) {
            $optParams['pageToken'] = $pageToken;
        }

        if (!is_null($domain)) {
            $optParams['domain'] = $domain;
        }

        return $service->users->listUsers($optParams);
    }

    /**
     * get List
     *
     * @param \App\Model\Entity\Directory|null $directory The Directory to Take Config From
     * @param null $domain Domain Limit
     * @param int $limit Page Size
     * @param string|null $pageToken String for Next Result Set
     * @return \Google_Service_Directory_Groups
     * @throws \Google_Exception
     */
    public static function getGroupList(
        ?Directory $directory = null,
        $domain = null,
        int $limit = 50,
        ?string $pageToken = null
    ): Google_Service_Directory_Groups {
        $service = GoogleBuilder::getService($directory);

        $customerReference = 'my_customer';
        if (!empty($directory->customer_reference)) {
            $customerReference = $directory->customer_reference;
        }

        $optParams = [
            'customer' => $customerReference,
            'maxResults' => $limit,
        ];

        if (!is_null($pageToken)) {
            $optParams['pageToken'] = $pageToken;
        }

        if (!is_null($domain)) {
            $optParams['domain'] = $domain;
        }

        return $service->groups->listGroups($optParams);
    }

    /**
     * get List
     *
     * @param string $userId ID for the Directory User
     *
     * @param \App\Model\Entity\Directory|null $directory The Directory to Take Config From
     * @return \Google_Service_Directory_User
     * @throws \Google_Exception
     */
    public static function getUser($userId, ?Directory $directory = null)
    {
        $service = GoogleBuilder::getService($directory);

        return $service->users->get($userId);
    }

    /**
     * get List
     *
     * @param \App\Model\Entity\Directory|null $directory The Directory to Take Config From
     * @return \Google_Service_Directory_Domains2
     * @throws \Google_Exception
     */
    public static function getDomainList(?Directory $directory = null)
    {
        $service = GoogleBuilder::getService($directory);

        return $service->domains->listDomains('my_customer');
    }
}
