<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2019-01-04
 * Time: 00:05
 */

namespace App\Http\Session;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Http\Session\DatabaseSession;

/**
 * Class ComboSession
 *
 * @package App\Http\Session
 */
class ComboSession extends DatabaseSession
{
    public $cacheKey;

    /**
     * ComboSession constructor.
     */
    public function __construct()
    {
        $this->cacheKey = Configure::read('Session.handler.cache');
        parent::__construct(Configure::read('Session.handler'));
    }

    /**
     * Method used to read from a database session.
     *
     * @param string|int $sessionId ID that uniquely identifies session in database.
     *
     * @return string Session data or empty string if it does not exist.
     */
    public function read($sessionId): string
    {
        $result = Cache::read($sessionId, $this->cacheKey);
        if ($result) {
            return $result;
        }

        return parent::read($sessionId);
    }

    /**
     * Helper function called on write for database sessions.
     *
     * @param string|int $sessionId ID that uniquely identifies session in database.
     * @param mixed $data The data to be saved.
     *
     * @return bool True for successful write, false otherwise.
     */
    public function write($sessionId, $data): bool
    {
        Cache::write($sessionId, $data, $this->cacheKey);

        return parent::write($sessionId, $data);
    }

    /**
     * Method called on the destruction of a database session.
     *
     * @param string|int $sessionId ID that uniquely identifies session in database.
     *
     * @return bool True for successful delete, false otherwise.
     */
    public function destroy($sessionId): bool
    {
        Cache::delete($sessionId, $this->cacheKey);

        return parent::destroy($sessionId);
    }
}
