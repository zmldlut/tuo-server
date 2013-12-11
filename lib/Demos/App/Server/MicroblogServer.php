<?php


require_once 'Demos/App/Server.php';

/**
 * @package Demos_App_Server
 */
class MicroblogServer extends Demos_App_Server
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
	 * > 接口说明：获取好友说说列表 
	 * <code>
	 * URL地址：/Microblog/blogList
	 * 提交方式：GET
	 * 参数#1：pageId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 好友说说列表接口
	 * @action /microblog/blogList
	 * @params pageId 0 INT
	 * @method get
	 */
	public function blogListAction ()
	{
		$this->doAuth();
		try {
			$pageId = intval($this->param('pageId'));
			$blogDao = $this->dao->load('Core_Microblog');
			$userDao = $this->dao->load('Core_User');
			$blogList = $blogDao->getFansListByUser($this->user['id'], $pageId);
			$list = array();
			if(is_array($blogList)){
				foreach ($blogList as $row) {
					if($row['userid']){
						$username = $userDao->getNameById($row['userid']);
						$blog = array(
								'id' => $row['id'],
								'userid' => $row['userid'],
								'username' => $username, ////
								'content' => $row['content'],
								'uptime' => $row['uptime'],
						);
						array_push($list, $blog);
					}
				}
			}
			
			$this->render('10000', 'Get blog list ok', array(
					'Microblog.list' => $list
			));

		} catch (Exception $e) {
			$this->render('14008', 'Get blog list failed! Error: '.$e->getMessage());
		}	
	}
	
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：获取用户说说列表
	 * <code>
	 * URL地址：/Microblog/userBlogList
	 * 提交方式：GET
	 * 参数#1：userId，类型：INT，必须：YES
	 * 参数#2：pageId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 用户说说列表接口
	 * @action /microblog/userBlogList
	 * @params userId 1 INT
	 * @params pageId 0 INT
	
	 * @method get
	 */
	public function userBlogListAction ()
	{
		$this->doAuth();
		try {
			$userId = intval($this->param('userId'));
			$pageId = intval($this->param('pageId'));
			$userDao = $this->dao->load('Core_User');
			$blogDao = $this->dao->load('Core_Microblog');
			$blogList = $blogDao->getOwnListByUser($userId, $pageId);
			
			$username = $userDao->getNameById($userId);
			$list = array();
			
			if(is_array($blogList)){
				foreach ($blogList as $row) {
					if($row['userid']){
						$blog = array(
								'id' => $row['id'],
								'userid' => $row['userid'],
								'username' => $username, ////
								'content' => $row['content'],
								'uptime' => $row['uptime'],
						);
						array_push($list, $blog);
					}
				}
			}
			$this->render('10000', 'Get blog list ok', array(
					'Microblog.list' => $list
			));
			
		} catch (Exception $e) {
			$this->render('14008', 'Get blog list failed! Error: '.$e->getMessage());
		}	
	}


	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：用户签到接口
	 * <code>
	 * URL地址：/microblog/checkin
	 * 提交方式：POST
	 * 参数#1：被踩用户id，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 用户签到接口
	 * @action /microblog/checkin
	 * @method post
	 */
	public function checkinAction ()
	{
		$this->doAuth();
		try {
			// 加分
			$userDao = $this->dao->load('Core_User');
			$userDao -> addScore($this->user['id'] , 1);
			
			// 发表说说
			$blogDao = $this->dao->load('Core_Microblog');
			$content = $this->user['name']." 今日已签到,成功获得1积分";
			$blogDao->create(array(
					'userid'	=> $this->user['id'],
					'content'	=> $content,
			));
			$this->render('10000','Check in ok',$content);
		} catch (Exception $e) {
			$this->render('14008', 'Check in failed! Error: '.$e->getMessage());
		}
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：踩一脚接口
	 * <code>
	 * URL地址：/microblog/stamp
	 * 提交方式：POST
	 * 参数#1：stampon，类型：STRING，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 踩一脚接口
	 * @action /microblog/stamp
	 * @params stamponId '' STRING
	 * @method post
	 */
	public function stampAction ()
	{
		$this->doAuth();
		
		try {
			$stamponId = intval($this->param("stamponId"));
			
			// 加减分
			$userDao = $this->dao->load('Core_User');
			$userDao -> addScore($this->user['id'] , 1);
			$userDao -> addScore($stamponId , -1);
			
			// 推送通知
			$noticeDao = $this->dao->load('Core_Notice');
			$noticeDao->create(
					array(
							'fromuserid'=> $this->user['id'],
							'userid' => $stamponId,
							'content' => $this->user['name']." 刚刚踩了你一脚，成功偷得1积分！"
					));
			
			$this->render('10000','Stamp friends ok',$content);
		} catch (Exception $e) {
			$this->render('14008', 'Stamp friends failed! Error: '.$e->getMessage());
		}

	}
}