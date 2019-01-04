<?php
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

class ComboSession extends DatabaseSession
{
	public $cacheKey;

	public function __construct()
	{
		$this->cacheKey = Configure::read('Session.handler.cache');
		parent::__construct(Configure::read('Session.handler'));
	}

	// Read data from the session.
	public function read($id)
	{
		$result = Cache::read($id, $this->cacheKey);
		if ($result) {
			return $result;
		}
		return parent::read($id);
	}

	// Write data into the session.
	public function write($id, $data)
	{
		Cache::write($id, $data, $this->cacheKey);
		return parent::write($id, $data);
	}

	// Destroy a session.
	public function destroy($id)
	{
		Cache::delete($id, $this->cacheKey);
		return parent::destroy($id);
	}

	// Removes expired sessions.
	public function gc($expires = null)
	{
		return Cache::gc($this->cacheKey) && parent::gc($expires);
	}
}