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

/**
 * @package Demos_Dao_Core
 */
class Core_Feedback extends Demos_Dao_Core
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'feedback';
	
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
	
// 	/**
// 	 * Get notification list
// 	 * @param int $userId
// 	 * @return array
// 	 */
// 	public function getByUser ($userId)
// 	{
// 		$sql = $this->select()->from($this->t1, '*')
// 			->where("userid = ?", $userId)
// 			->where("status = 0")
// 			->order("{$this->t1}.uptime desc");
		
// 		$row = $this->dbr()->fetchAll($sql);
// 		$msg = trim($row['content']);
// 		// when message is empty 
// 		if (strlen($msg) > 0) {
// 			return $row;
// 		}
// 		// return null
// 		return null;
// 	}
	
// 	/**
// 	 * Get notification
// 	 * @param int $Id
// 	 * @return notice
// 	 */
// 	public function getById ($Id)
// 	{
// 		$sql = $this->select()->from($this->t1, '*')
// 		->where("id = ?", $Id)
// 		->where("status = 0");
	
// 		$row = $this->dbr()->fetchRow($sql);
// 		$msg = trim($row['content']);
// 		// when message is empty
// 		if (strlen($msg) > 0) {
// 			return $row;
// 		}
// 		// return null
// 		return null;
// 	}
}
