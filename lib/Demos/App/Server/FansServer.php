<?php
require_once 'Demos/App/Server.php';

/**
 * @package Demos_App_Server
 */
class FansServer extends Demos_App_Server
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
	 * URL地址：/fans/fansList
	 * 提交方式：GET
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 获取好友列表 
	 * @action /fans/fansList
	 * @method get
	 */
	public function fansListAction ()
	{
		$this -> doAuth();
		
		$relationDao = $this->dao->load('Core_Relationship');
		$fanslist = $relationDao -> getFansList($this->user['id']);
		if(!$fanslist){
			$this ->render('15001','Get fans list failed');
		}
		$this->render('10000', 'Get fans list ok', array(
				'Fans.list' => $fanslist
		));
	}
	
}
