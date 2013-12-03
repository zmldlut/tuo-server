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
class IndexServer extends Demos_App_Server
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
	 * > 接口说明：测试接口
	 * <code>
	 * URL地址：/index/index
	 * 提交方式：POST
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 测试接口
	 * @action /index/index
	 * @method get
	 */
	public function indexAction ()
	{
		$this->doAuth();
		
		// get extra user info
		$userDao = $this->dao->load('Core_User');
		$userItem = $userDao->getById($this->user['id']);
		$this->render('10000', 'Load index ok', array(
			'user' => $userItem
		));
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：用户登录接口
	 * <code>
	 * URL地址：/index/login
	 * 提交方式：POST
	 * 参数#1：name，类型：STRING，必须：YES，示例：admin
	 * 参数#2：pass，类型：STRING，必须：YES，示例：admin
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 用户登录接口
	 * @action /index/login
	 * @params name james STRING
	 * @params pass james STRING
	 * @method post
	 */
	public function loginAction ()
	{
		// return login user
		$name = $this->param('name');
		$pass = $this->param('pass');
		if ($name && $pass) {
			$userDao = $this->dao->load('Core_User');
			$user = $userDao->doAuth($name, $pass);
			if ($user) {
				$user['sid'] = session_id();
				$_SESSION['user'] = $user;
				$this->render('10000', 'Login ok', array(
					'user' => $user
				));
			}
		}
		// return sid only for client
		$user = array('sid' => session_id());
		$this->render('14001', 'Login failed', array(
			'user' => $user
		));
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：用户登出接口
	 * <code>
	 * URL地址：/index/logout
	 * 提交方式：POST
	 * 参数#1：sid，类型：STRING，必须：YES，示例：
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 用户登出接口
	 * @action /index/logout
	 * @method post
	 */
	public function logoutAction ()
	{
		$_SESSION['user'] = null;
		$this->render('10000', 'Logout ok');
	}
}