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
class NotifyServer extends Demos_App_Server
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
	 * > 接口说明：获取通知列表接口
	 * <code>
	 * URL地址：/notify/noticeList
	 * 提交方式：POST
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 获取通知列表接口
	 * @action /notify/noticeList
	 * @method get
	 */
	public function noticeListAction ()
	{
		$this->doAuth();
		
		try {
			// get extra customer info
			$noticeDao = $this->dao->load('Core_Notice');
			$noticeList = $noticeDao->getByUser($this->user['id']);
			$list = array();
			
			if(is_array($noticeList)){
				foreach ($noticeList as $row) {
					if($row['fromuserid'] && $row['userid']){
						$fromusername = $userDao->getNameById($row['fromuserid']);
						$username = $userDao->getNameById($row['userid']);
						$notice = array(
								'id' => $row['id'],
								'fromuserid' => $row['fromuserid'],
								'fromname' => $fromusername,////
								'userid' => $row['userid'],
								'username' => $username, ////
								'content' => $row['content'],
								'type' => $row['type'],
								'status' => $row['status'],
								'uptime' => $row['uptime'],
						);
						array_push($list, $notice);
					}
				}
			}
			
			$this->render('10000', 'Get notification ok', array(
						'Notice.list' => $list
				));
		} catch (Exception $e) {
			$this->render('14013', 'Get notification failed! Error:'.$e->getMessage());
		}
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：设置通知为已读接口
	 * <code>
	 * URL地址：/notify/noticeSetRead
	 * 提交方式：POST
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 设置通知为已读接口
	 * @action /notify/noticeSetRead
	 * @method get
	 */
	public function noticeSetReadAction ()
	{
		$this->doAuth();
		
		try {
			$id = $this->param('id');
			// get extra customer info
			$noticeDao = $this->dao->load('Core_Notice');
			$noticeItem = $noticeDao->getById($id);
			if ($noticeItem) {
				$noticeDao->setReadById($id);
				$this->render('10000', 'notification set readed ok');
			}
			$this->render('14013', 'notification set readed failed! Error:'.'数据库中没有该消息！');
		} catch (Exception $e) {
			$this->render('14013', 'notification set readed failed! Error:'.$e->getMessage());
		}	
	}
}