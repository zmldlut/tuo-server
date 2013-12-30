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
class FeedbackServer extends Demos_App_Server
{
	

	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：用户反馈信息接口
	 * <code>
	 * URL地址：/feedback/add
	 * 参数#1：userid，类型：INT，必须：YES，示例：1
	 * 参数#2：username，类型：STRING，必须：YES，示例：james
	 * 参数#3：content，类型：STRING，必须：YES，示例：hello world!
	 * 提交方式：POST
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 反馈信息接口
	 * @action /feedback/add
	 * @params userid 1  INT
	 * @params username james STRING
	 * @params content Hello_world! STRING
	 * @method post
	 */
	public function addAction ()
	{
		try {
			// return 注册成功
			$feedback = array();
			$feedback['userid'] = $this->param('userid');
			$feedback['username'] = $this->param('username');
			$feedback['content'] = $this->param('content');
			
			$new_feedback = $this->dao->load('Core_Feedback');
			
			$new_feedback->create(array(
					'userid' => $feedback['userid'],
					'username' => $feedback['username'],
					'content' => $feedback['content'],
			));
			$this->render('10000', 'Add ok');
		} catch (Exception $e) {
			$this->render('14001', 'Add failed! error:'.$e->getMessage());
		}
	}	
}

?>