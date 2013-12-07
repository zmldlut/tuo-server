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
class Core_Relationship extends Demos_Dao_Core
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'relationship';
	
	/**
	 * @static
	 */
	const TABLE_PRIM = '';
	
	/**
	 * Initialize
	 */
	public function __init () 
	{
		$this->t1 = self::TABLE_NAME;
		
		$this->_bindTable($this->t1);
	}
	/**
	 * 获取好友列表
	 *
	 * @param string $userId
	 * @return
	 */
	public function getFansList($userId)
	{
		$list = array();
		$sql = $this->select()->from($this->t1, '*')
		->where("userid = ?", $userId);
		$res = $this->dbr()->fetchAll($sql);
	
		if ($res)
		{
			$userDao = $this->load('Core_User');
			foreach ($res as $row) {
				$fans = $userDao->read($row['fansid']);
				array_push($list, $fans);
			}
		}
		$userid = $userDao->read($row['userid']);
		array_push($list, $userid);
		return $list;
	}
	/**
	 * 判断是否是好友关系
	 *
	 * @param string $userIdA 
	 * @param string $userIdB 
	 * @return array 基本形式{id，name，score}
	 */
	public function existRelationShip($userIdA,$userIdB)
	{
		
		$sql = $this->select()->from($this->t1, '*')
		->where("userid = ?", $userIdA)
		->where("fansid = ?", $userIdB);
		$res = $this->dbr()->fetchRow($sql);
		if ($res)
		{
			return true;
		}
		return false;
	}
	
	public function deleteRelationShip ($userIdA, $userIdB)
	{
		$wheresql = "userid = $userIdA and fansid = $userIdB";
		return $this->dbw()->delete($this->t1, $wheresql);
	}
	

	
// 	/**
// 	 * Check fans data exists
// 	 * @param int $customerId
// 	 * @param int $fansId
// 	 * @return array
// 	 */
// 	public function exist ($customerId, $fansId)
// 	{
// 		$sql = $this->select()->from($this->t1, '(1)')
// 			->where("customerid = ?", $customerId)
// 			->where("fansid = ?", $fansId);
		
// 		return $this->dbr()->fetchOne($sql);
// 	}
	
// 	/**
// 	 * Delete fans data
// 	 * @param int $customerId
// 	 * @param int $fansId
// 	 */
// 	public function delete ($customerId, $fansId) 
// 	{
// 		$wheresql = "customerid = $customerId and fansid = $fansId";
// 		return $this->dbw()->delete($this->t1, $wheresql);
// 	}
	
// 	/**
// 	 * Count fans number
// 	 * @param int $customerId
// 	 * @param int $fansId
// 	 * @return array
// 	 */
// 	public function countFans ($customerId)
// 	{
// 		$sql = $this->select()->from($this->t1, '(1)')
// 			->where("customerid = ?", $customerId);
		
// 		return $this->dbr()->fetchOne($sql);
// 	}
}
