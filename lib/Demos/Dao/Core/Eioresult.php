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
class Core_Eioresult extends Demos_Dao_Core
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'eioresult';
	
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
	 * 获取用户做过的eio结果列表
	 * @param int $userId
	 * @param int $pageId
	 * @return array
	 */
	public function getEioListByUser ($userId, $pageId=0)
	{
		$sql = $this->select()->from($this->t1, '*')
		->where("userid = ?", $userId)
		->order("{$this->t1}.uptime desc")
		->limitPage($pageId, 10);
		$row = $this->dbr()->fetchAll($sql);
		return row;
	}
	
	/**
	 * 根据eioId获取Eio结果
	 * @params int $userId
	 * @params int $eioId
	 * @return array
	 */
	public function getEioByEioId ($userId,$eioId)
	{
		$sql = $this->select()->from($this->t1, '*')
		->where("userid = ?", $userId)
		->where("eioid = ?",$eioId);
	
		$row = $this->dbr()->fetchRow($sql);
		return row;
	}
}