<?php
declare(strict_types=1);

namespace App\Controller\Component;

use App\Utility\GoogleBuilder;
use Cake\Controller\Component;

/**
 * GoogleClient component
 */
class GoogleClientComponent extends Component
{
    /**
     * get List
     *
     * @param null $domain Domain Limit
     * @param int $limit Page Size
     * @param string|null $pageToken String for Next Result Set
     * @return \Google_Service_Directory_Users
     */
    public function getList($domain = null, int $limit = 50, ?string $pageToken = null)
    {
        return GoogleBuilder::getList($domain, $limit, $pageToken);
    }

    /**
     * get List
     *
     * @param string $userId User ID to be retrieved
     * @return \Google_Service_Directory_User
     */
    public function getUser($userId)
    {
        return GoogleBuilder::getUser($userId);
    }

    /**
     * get List
     *
     * @return \Google_Service_Directory_Domains2
     */
    public function getDomainList()
    {
        return GoogleBuilder::getDomainList();
    }
}
