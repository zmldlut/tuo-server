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
class Core_Eiocontent extends Demos_Dao_Core
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'eiocontent';
	
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
	 * 获取问题列表
	 * @param int $eioId
	 * @param int $pageId
	 * @return array $list
	 */
	public function getContent($eioId,$pageId=0)
	{
		$list = array();
		$sql = $this->select()
		->from($this->t1, '*')
		->where("{$this->t1}.eioid =?", $eioId)
		->limitPage($pageId, 10);
		$list = $this->dbr()->fetchAll($sql);
		return $list;
	}
	
	public function listTrueAnswer($eioId)
	{
		$list = array();
		$res = $this->getContent($eioId);
		foreach ($res as $row){
			$list[$row['id']] = $row['trueanswer'];
		}
		return $list;
	}
}