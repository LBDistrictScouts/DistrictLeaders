<?php

declare(strict_types=1);

namespace App\Controller\Component;

use App\Model\Entity\Directory;
use App\Utility\GoogleBuilder;
use Cake\Controller\Component;
use Google_Client;
use Google_Exception;
use Google_Service_Directory_Domains2;
use Google_Service_Directory_User;
use Google_Service_Directory_Users;

/**
 * GoogleClient component
 */
class GoogleClientComponent extends Component
{
    /**
     * get List
     *
     * @param Directory $directory The Directory Authentication
     * @param null $domain Domain Limit
     * @param int $limit Page Size
     * @param string|null $pageToken String for Next Result Set
     * @return Google_Service_Directory_Users
     * @throws Google_Exception
     */
    public function getUserList(Directory $directory, $domain = null, int $limit = 50, ?string $pageToken = null)
    {
        return GoogleBuilder::getUserList($directory, $domain, $limit, $pageToken);
    }

    /**
     * get List
     *
     * @param Directory $directory The Directory Entity
     * @param string $userId User ID to be retrieved
     * @return Google_Service_Directory_User
     * @throws Google_Exception
     */
    public function getUser(Directory $directory, $userId)
    {
        return GoogleBuilder::getUser($userId, $directory);
    }

    /**
     * get List
     *
     * @return Google_Service_Directory_Domains2
     * @throws Google_Exception
     */
    public function getDomainList()
    {
        return GoogleBuilder::getDomainList();
    }

    /**
     * @return Google_Client
     * @throws Google_Exception
     */
    public function newClient(): Google_Client
    {
        return GoogleBuilder::newClient();
    }

    /**
     * @param Google_Client $client The Instantiated Google Client
     * @param Directory $directory The Directory Instance
     * @return Google_Client
     */
    public function getToken(Google_Client $client, Directory $directory): Google_Client
    {
        return GoogleBuilder::getToken($client, $directory);
    }

    /**
     * Save Token Method
     *
     * @param Google_Client $client An Activated Client
     * @param Directory $directory The Directory to Save Config To
     * @return void
     */
    public function saveToken(Google_Client $client, Directory $directory)
    {
        GoogleBuilder::saveToken($client, $directory);
    }
}
