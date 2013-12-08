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
class Core_Eio extends Demos_Dao_Core
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'eio';
	
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
	 * 根据类别来获取问卷列表
	 * @param int $classifyId
	 * @param int $pageId
	 * @return array $list
	 */
	public function getListByClassify($classifyId,$pageId)
	{
		if($classifyId==1){ // 1为热门问卷
			return $this->getHotList($pageId);
		}
			
		$list = array();
		$sql = $this->select()
		->from($this->t1, '*')
		->where("{$this->t1}.classifyid = ?", $classifyId)
		->order("{$this->t1}.publishtime desc")
		->limitPage($pageId, 10);
		
		$list = $this->dbr()->fetchAll($sql);
		return $list;
	}
	
	/**
	 * 获取热门问卷列表
	 * @param int $pageId
	 * @return array $list
	 */
	public function getHotList($pageId)
	{
		$list = array();
		$sql = $this->select()
		->from($this->t1, '*')
		->order("{$this->t1}.didcount desc")
		->limitPage($pageId, 10);
		$list = $this->dbr()->fetchAll($sql);
		return $list;
	}
	
	/**
	 * 问卷查询
	 * @param string $name
	 * @param int $pageId
	 * @return array $list
	 */
	public function searchList($name,$pageId)
	{
		$list = array();
		$name = "%$name%";
		$sql = $this->select()
		->from($this->t1, '*')
		->where("{$this->t1}.title LIKE ?", $name)
		->order("{$this->t1}.publishtime desc")
		->limitPage($pageId, 10);
		
		$list = $this->dbr()->fetchAll($sql);
		return $list;
	}
	
}