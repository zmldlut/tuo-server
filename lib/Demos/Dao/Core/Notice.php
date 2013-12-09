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
class Core_Notice extends Demos_Dao_Core
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'notice';
	
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
	 * Set notice read
	 * @param int $userId
	 */
	public function setRead ($userId) {
		$sql = $this->select()->from($this->t1, '*')
			->where("userid = ?", $userId)
			->where("status = 0");
		
		$row = $this->dbr()->fetchRow($sql);
		if ($row) {
			$this->update(array(
				'id'		=> intval($row['id']),
				'status'	=> 1
			));
		}
	}
	
	/**
	 * Set notice read
	 * @param int $id
	 */
	public function setReadById ($id) {
		$sql = $this->select()->from($this->t1, '*')
		->where("id = ?", $id)
		->where("status = 0");
	
		$row = $this->dbr()->fetchRow($sql);
		if ($row) {
			$this->update(array(
					'id'		=> intval($row['id']),
					'status'	=> 1
			));
		}
	}
	
// 	/**
// 	 * Add fanscount by one
// 	 * @param int $customerId
// 	 */
// 	public function addFanscount ($customerId, $addCount = 1)
// 	{
// 		$sql = $this->select()->from($this->t1, '*')
// 			->where("customerid = ?", $customerId)
// 			->where("status = 0");
		
// 		$row = $this->dbr()->fetchRow($sql);
// 		// update
// 		if ($row) {
// 			$fanscount = intval($row['fanscount']) + $addCount;
// 			$this->update(array(
// 				'id'		=> intval($row['id']),
// 				'fanscount'	=> $fanscount
// 			));
// 		// insert
// 		} else {
// 			$this->create(array(
// 				'customerid'	=> $customerId,
// 				'fanscount'		=> 1
// 			));
// 		}
// 	}
	
	/**
	 * Get notification list
	 * @param int $userId
	 * @return array
	 */
	public function getByUser ($userId)
	{
		$sql = $this->select()->from($this->t1, '*')
			->where("userid = ?", $userId)
			->where("status = 0");
		
		$row = $this->dbr()->fetchAll($sql);
		$msg = trim($row['content']);
		// when message is empty 
		if (strlen($msg) > 0) {
			return $row;
		}
		// return null
		return null;
	}
	
	/**
	 * Get notification
	 * @param int $Id
	 * @return notice
	 */
	public function getById ($Id)
	{
		$sql = $this->select()->from($this->t1, '*')
		->where("id = ?", $Id)
		->where("status = 0");
	
		$row = $this->dbr()->fetchRow($sql);
		$msg = trim($row['content']);
		// when message is empty
		if (strlen($msg) > 0) {
			return $row;
		}
		// return null
		return null;
	}
}
