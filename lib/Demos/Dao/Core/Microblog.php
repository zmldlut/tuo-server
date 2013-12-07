<?php
/**
 * Demos Dao
 *
 * @category   Demos
 * @package    Demos_Dao_Core
 * @author     Minlei.Zhang <zml@mail.dlut.edu.cn>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

require_once 'Demos/Dao/Core.php';
require_once 'Demos/Util/Image.php';

/**
 * @package Demos_Dao_Core
 */
class Core_Microblog extends Demos_Dao_Core
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'microblog';
	
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
	 * 获取$userId用户自己的说说列表
	 *
	 * @param string $userId
	 * @param int $pageId
	 */
	public function getOwnListByUser($userId,$pageId=0)
	{
		$list = array();
		$sql = $this->select()
		->from($this->t1, '*')
		->where("{$this->t1}.userid = ?", $userId)
		->order("{$this->t1}.uptime desc")
		->limitPage($pageId, 10);
	
		$res = $this->dbr()->fetchAll($sql);
		if ($res) {
			$userDao = $this->load("Core_User");
			foreach ($res as $row) {
				$blog = array(
						'id'		=> $row['id'],
						'name'		=> $userDao -> getNameById($row['userid']),
						'content'	=> $row['content'],
						'uptime'	=> $row['uptime'],
				);
				array_push($list, $blog);
			}
		}
		return $list;
	}
	
	/**
	 * 获取$userId用户好友的说说列表
	 *
	 * @param string $userId
	 * @param int $pageId
	 */
	public function getFansListByUser($userId,$pageId=0)
	{
		$list = array();
		$relationDao = $this->load("Core_Relationship");
		$fansArr = $relationDao -> getFansList($userId);
	
		if(!$fansArr)
		{
			return;
		}
		// 构建遍历条件$condition
		$temp = 0;
		foreach ($fansArr as $fans)
		{
			if(!($temp++==0)){
				$condition .= " OR ";
			}
			$condition  .=  "{$this->t1}.userid = ".$fans['id'];
		}
		//echo $condition;
		$sql = $this->select()
		->from($this->t1, '*')
		->where($condition)
		->order("{$this->t1}.uptime desc")
		->limitPage($pageId, 10);
	
		$res = $this->dbr()->fetchAll($sql);
		if ($res) {
			$userDao = $this->load("Core_User");
			foreach ($res as $row) {
				$blog = array(
						'id'		=> $row['id'],
						'name'		=> $userDao -> getNameById($row['userid']),
						'content'	=> $row['content'],
						'uptime'	=> $row['uptime'],
				);
				array_push($list, $blog);
			}
		}
		return $list;
	}
}