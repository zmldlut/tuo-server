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
			'User' => $userItem
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
		try {
			$name = $this->param('name');
			$pass = $this->param('pass');
			if ($name && $pass) {
				$userDao = $this->dao->load('Core_User');
				$user = $userDao->doAuth($name, $pass);
				if ($user) {
					$user['sid'] = session_id();
					$_SESSION['user'] = $user;
					$this->render('10000', 'Login ok', array(
							'User' => $user
					));
				}
			}
			// return sid only for client
			$user = array('sid' => session_id());
		} catch (Exception $e) {
			$this->render('14001', 'Login failed! error:'.$e->getMessage(), array(
					'User' => $user
			));
		}	
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
		try {
			$_SESSION['user'] = null;
			$this->render('10000', 'Logout ok');
		} catch (Exception $e) {
			$this->render('14001', 'Logout failed! error:'.$e->getMessage());
		}
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：用户注册接口
	 * <code>
	 * URL地址：/index/register
	 * 提交方式：POST
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 用户注册接口
	 * @action /index/register
	 * @method post
	 */
	public function registerAction ()
	{
		try {
			// return 注册成功
			$registeruser = $this->param('user');
			$user = $this->dao->load('Core_User');
			
			//判断账号是否存在
			if($user->getByName($registeruser['name'])){
				$this->render('10009', 'This name already exists!');
			}
			$user->create(array(
					'name' => $registeruser['name'],
					'pass' => $registeruser['pass'],
					'sign' => $registeruser['sign'],
					'face' => $registeruser['face'],
					'sex' => $registeruser['sex'],
					'birthday' => $registeruser['birthday'],
					'location' => $registeruser['location'],
					'eiocount' => $registeruser['eiocount'],
					'fanscount' => $registeruser['fanscount'],
					'score' => $registeruser['score'],
			));
			// 		$user->create(array(
			// 				'name' => 'zml',
			// 				'pass' => 'zml',
			// 				'sign' => 'Happying',
			// 				'face' => '0',
			// 				'sex' => 0,
			// 				'birthday' => '2013-1-1',
			// 				'location' => 'henan',
			// 				'eiocount' => 0,
			// 				'fanscount' => 0,
			// 				'score' => 0,
			// 		));
			$this->render('10000', 'Register ok');
		} catch (Exception $e) {
			$this->render('14001', 'Register failed! error:'.$e->getMessage());
		}

	}	
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：更新用户信息接口
	 * <code>
	 * URL地址：/index/update
	 * 提交方式：POST
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 更新用户信息接口
	 * @action /index/update
	 * @method post
	 */
	public function updateAction ()
	{
		$this->doAuth();

		try {
			$registeruser = $this->param('user');
			$user = $this->dao->load('Core_User');
			
			//判断账号是否存在
			if(!$user->getByName($registeruser['name'])){
				$this->render('10009', 'This account is not exists!');
			}
			$user->update(array(
					'id' => $registeruser['id'],
					'name' => $registeruser['name'],
					'pass' => $registeruser['pass'],
					'sign' => $registeruser['sign'],
					'face' => $registeruser['face'],
					'sex' => $registeruser['sex'],
					'birthday' => $registeruser['birthday'],
					'location' => $registeruser['location'],
					'eiocount' => $registeruser['eiocount'],
					'fanscount' => $registeruser['fanscount'],
					'score' => $registeruser['score'],
			));
			$this->render('10000', '个人信息更新成功！');
		} catch (Exception $e) {
			$this->render('14001', '个人信息更新失败！error:'.$e->getMessage());
		}

	}
}