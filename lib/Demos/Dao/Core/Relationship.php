<?php

/**
 * 
 * 
 */
require_once 'Demos/Dao/Core.php';
require_once 'Demos/Dao/Core/User.php';


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
	 * Initialize
	 */
	public function __init ()
	{
		$this->t1 = self::TABLE_NAME;
		$this->_bindTable($this->t1, $this->k1);
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
			$userDao = new Core_User();
			foreach ($res as $row) {	
				$fans = $userDao->read($row['fansid']);
				array_push($list, $fans);
			}
		}
		return $list;
	}
}