<?php
/**
 * Demos Dao
 *
 * @category   Demos
 * @package    Demos_Dao_Core
 * @author     linwei
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

require_once 'Demos/Dao/Core.php';

/**
 * @package Demos_Dao_Core
 */
class Core_Eiocomment extends Demos_Dao_Core
{
	/**
	 * @static
	 */
	const TABLE_NAME = 'eiocomment';
	
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
	 *	获取问卷的评论
	 * @param int $eioId
	 * @param int $pageId
	 */
	public function getListByEio ($eioId, $pageId = 0)
	{
		$list = array();
		$sql = $this->select()
			->from($this->t1, '*')
			->where("{$this->t1}.eioid = ?", $eioId)
			->order("{$this->t1}.uptime desc")
			->limitPage($pageId, 10);
		
		$res = $this->dbr()->fetchAll($sql);
		if ($res) {
			$userDao = $this->load('Core_User');
			foreach ($res as $row) {
				$userName = $userDao->getNameById($row['userid']);
				$comment = array(
					'id'		=> $row['id'],
					'content'	=> "$userName: ".$row['content'],
					'uptime'	=> $row['uptime'],
				);
				array_push($list, $comment);
			}
		}
		return $list;
	}
	
	/**
	 * 添加评论
	 * @param unknown $eioId
	 * @param unknown $userId
	 * @param unknown $content
	 */
	public function addComment($eioId, $userId,$content)
	{
		
		$this->create(array(
			'eioid' => $eioId,
			'userid' => $userId,
			'content' => $content,
		));
		
	}
}