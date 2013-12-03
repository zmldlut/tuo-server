<?php
/**
 * Demos Dao
 *
 * @category   Demos
 * @package    Demos_Dao_Core
 * @author     James.Huang <shagoo@gmail.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

require_once 'Demos/Dao/Core.php';
require_once 'Demos/Util/Image.php';

/**
 * @package Demos_Dao_Core
 */
class Core_User extends Demos_Dao_Core
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'user';
	
	/**
	 * @static
	 */
	const TABLE_PRIM = 'id';
	
	/**
	 * Initialize
	 */
	public function __init () 
	{
		$this->t1 = self::TABLE_NAME;
		$this->k1 = self::TABLE_PRIM;
		$this->_bindTable($this->t1, $this->k1);
	}
	
	/**
	 * User login
	 * @param string $user
	 * @param string $pass
	 */
	public function doAuth ($user, $pass)
	{
		$sql = $this->select()
			->from($this->t1, '*')
			->where("{$this->t1}.name = ?", $user)
			->where("{$this->t1}.pass = ?", $pass);
		
		$user = $this->dbr()->fetchRow($sql);
		if ($user) return $user;
		return false;
	}
	
	/**
	 * Get user by id
	 * @param int $id
	 */
	public function getById ($id) {
		$user = $this->read($id);
		$user['faceurl'] = Demos_Util_Image::getFaceUrl($user['face']);
		return $user;
	}
	
	/**
	 * Get user name by id
	 * @param int $id
	 */
	public function getNameById ($id) {
		$user = $this->read($id);
		return $user['name'];
	}
	
	/**
	 * Add blogcount by one
	 * @param int $id
	 */
	public function addEIOcount ($id, $addCount = 1)
	{
		$user = $this->read($id);
		$user['eiocount'] = $user['eiocount'] + $addCount;
		$this->update($user);
	}
	
	/**
	 * Add fanscount by one
	 * @param int $id
	 */
	public function addFriendscount ($id, $addCount = 1)
	{
		$user = $this->read($id);
		$user['fanscount'] = intval($user['fanscount']) + $addCount;
		$this->update($user);
	}
	
	/**
	 * Add fanscount by one
	 * @param int $id
	 */
	public function addScore ($id, $addScore = 1)
	{
		$user = $this->read($id);
		$user['score'] = intval($user['score']) + $addScore;
		$this->update($user);
	}
	
}