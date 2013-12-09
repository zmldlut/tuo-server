<?php
/**
 * Demos App
 *
 * @category   Demos
 * @package    Demos_App_Server
 * @author     James.Huang <huangjuanshi@163.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

require_once 'Demos/App/Server.php';

/**
 * @package Demos_App_Server
 */
class FriendsServer extends Demos_App_Server
{
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 全局设置：
	 * <code>
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 */
	public function __init ()
	{
		parent::__init();
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// service api methods
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：获取好友列表
	 * <code>
	 * URL地址：/Friends/fansList
	 * 提交方式：GET
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 获取好友列表
	 * @action /Friends/fansList
	 * @method get
	 */
	public function fansListAction ()
	{
		$this -> doAuth();
		
		try {
			$relationDao = $this->dao->load('Core_Relationship');
			$fanslist = $relationDao -> getFansList($this->user['id']);
			if(!$fanslist){
				$this ->render('15001','Get fans list failed');
			}
			$this->render('10000', 'Get fans list ok', array(
					'Fans.list' => $fanslist
			));
		} catch (Exception $e) {
			$this->render('14013', 'Get fans list failed! Error:'.$e->getMessage());
		}
	}
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：搜索好友接口
	 * <code>
	 * URL地址：/Friends/search
	 * 提交方式：POST
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 搜索好友接口
	 * @action /Friends/search
	 * @params name james STRING
	 * @method get
	 */
	public function searchAction ()
	{
		$this->doAuth();
		
		try {
			$name = $this->param('name');
			// get extra user info
			$friends = $this->dao->load('Core_User');
			
			$friend = $friends->getByName($name);
			if($friend){
				$this->render('10000', 'Search friend ok!', array(
						'friend' => $friend
				));
			}
		} catch (Exception $e) {
			$this->render('14013', 'Search friend failed! Error:'.$e->getMessage());
		}	
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：添加好友接口
	 * <code>
	 * URL地址：/Friends/add
	 * 提交方式：POST
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 添加好友接口
	 * @action /Friends/add
	 * @params userid 1 INT
	 * @method get
	 */
	public function addAction ()
	{
		$this->doAuth();
	
		try {
			$userid = $this->param('userid');
			// get extra user info
			$relationship = $this->dao->load('Core_Relationship');
			// 		$friend = $relationship->getById($id);
			if(!$relationship->existRelationShip($this->user['id'], $userid)){
					
				$relationship->create(array(
						'userid' => $this->user[id],
						'fansid' => $userid,
				));
				$this->render('10000', 'Add friend ok!');
			}
			else
			{
				$this->render('10009', '该用户已经是您的好友！');
			}
		} catch (Exception $e) {
			$this->render('14013', 'Add friend failed! Error:'.$e->getMessage());
		}		
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：删除好友接口
	 * <code>
	 * URL地址：/Friends/del
	 * 提交方式：POST
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 删除好友接口
	 * @action /Friends/del
	 * @params userid 1 INT
	 * @method get
	 */
	public function delAction ()
	{
		$this->doAuth();
	
		try {
			$userid = $this->param('userid');
			// get extra user info
			$relationship = $this->dao->load('Core_Relationship');
			// 		$friend = $relationship->getById($id);
			if($relationship->existRelationShip($this->user['id'], $userid)){
			
				$relationship->deleteRelationShip($this->user['id'],$userid);
				$this->render('10000', 'Del friend ok!');
			}
			else
			{
				$this->render('10009', '用户不是您的好友！');
			}
		} catch (Exception $e) {
			$this->render('14013', 'Del friend failed! Error:'.$e->getMessage());
		}	
	}
}