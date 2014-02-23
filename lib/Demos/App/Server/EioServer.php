<?php

/**
 * Demos App
 * 
 * @author linwei
 * @version 1
 */
	
require_once 'Demos/App/Server.php';

class EioServer extends Demos_App_Server
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
	 * > 接口说明：获取问卷分类接口
	 * <code>
	 * URL地址：/eio/classifyList
	 * 提交方式：GET
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 获取问卷分类接口
	 * @action /eio/classifyList
	 * @method get
	 */
	public function classifyListAction ()
	{
		$this->doAuth();
		
		try {
			$classifylist = array();
			$classifyDao = $this->dao->load("Core_Eioclassify");
			$classifylist = $classifyDao->getClassifyList();
			if ($classifylist) {
				$this->render('10000', 'Get classify list ok', array(
						'Classify.list' => $classifylist
				));
			}
			$this->render('14009', 'Get classify list failed! Error:'.$e->getMessage());
		} catch (Exception $e) {
			$this->render('14009', 'Get classify list failed! Error:'.$e->getMessage());
		}	
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：获取某类问卷列表接口
	 * <code>
	 * URL地址：/eio/eioList
	 * 提交方式：GET
	 * 参数#1：classifyId，类型：INT，必须：YES
	 * 参数#2：pageId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 获取某类问卷列表接口
	 * @action /eio/eioList
	 * @params classifyId 1 STRING
	 * @params pageId 0 INT
	 * @method get
	 */
	public function eioListAction ()
	{
		$this->doAuth();
		
		try {
			$classifyId = intval($this->param('classifyId'));
			$pageId = intval($this->param('pageId'));
			
			$eioList = array();
			$eioDao = $this->dao->load('Core_Eio');
			$eioList = $eioDao->getListByClassify($classifyId, $pageId);
	
			$this->render('10000', 'Get eio list ok', array(
					'Eio.list' => $eioList
			));

		} catch (Exception $e) {
			$this->render('14010', 'Get eio list failed! Error:'.$e->getMessage());
		}	
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：搜索问卷接口
	 * <code>
	 * URL地址：/eio/search
	 * 提交方式：GET
	 * 参数#1：name，类型：STRING，必须：YES
	 * 参数#2：pageId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 搜索问卷接口
	 * @action /eio/search
	 * @params name '' STRING
	 * @params pageId 0 INT
	 * @method get
	 */
	public function searchAction ()
	{
		$this->doAuth();
		
		try {
			$name = $this->param('name');
			$pageId = intval($this->param('pageId'));
			
			$eioList = array();
			$eioDao = $this->dao->load('Core_Eio');
			$eioList = $eioDao->searchList($name, $pageId);

			$this->render('10000', 'Search eio list ok', array(
					'Eio.list' => $eioList
			));

		} catch (Exception $e) {
			$this->render('14011', 'Search eio list failed! Error:'.$e->getMessage());
		}	
	}
    
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：获取问题列表接口
	 * <code>
	 * URL地址：/eio/quesList
	 * 提交方式：GET
	 * 参数#1：eioId，类型：INT，必须：YES
	 * 参数#2：pageId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 获取问题列表接口
	 * @action /eio/quesList
	 * @params eioId  1 INT
	 * @params pageId 0 INT
	 * @method get
	 */
	public function quesListAction ()
	{
		$this->doAuth();
		
		try {
			$eioId = $this->param('eioId');
			$pageId = intval($this->param('pageId'));
			
			$eioContentDao = $this->dao->load('Core_Eiocontent');
			$quesList = $eioContentDao->getContent($eioId,$pageId);
			
			$eioDao = $this->dao->load('Core_Eio');
			$typeName = $eioDao-> getTypeName($eioId);
			$this->render('10000', 'Get eio content list ok', array(
					"$typeName.list" => $quesList
			));
		} catch (Exception $e) {
			$this->render('14012', 'Get eio content list failed! Error: '.$e->getMessage());
		}	
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：提交问题结果，返回处理数据
	 * <code>
	 * URL地址：/eio/dispose
	 * 提交方式：POST
	 * 参数#1：eioId，类型：INT，必须：YES
	 * 参数#2：pageId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 提交问题结果，返回处理数据
	 * @action /eio/dispose
	 * @params eioId  1 INT
	 * @params result {"1":"1","2":"2","3":"1"} STRING
	 * @method post
	 */
	public function disposeAction ()
	{
		$this->doAuth();
		// TODO add dispse method
		//echo $this->user['id'];
		$eioId = $this->param('eioId');
		$result = $this->param('result');
		$resultList = json_decode($result,true); // 强制生成数组 json_decode($arr,true)
        
		
		// 获取问卷类型决定评分方式
		$eioDao = $this->dao->load('Core_Eio');
		$typeName = $eioDao-> getTypeName($eioId);
		
		// 添加完成次数
		$eioDao->addDidcount($eioId);
		
		$score = 0;
		if(!strcmp($typeName,'SimpleSelectQuestion')) // 单项选择题
		{
		    
			$eioContentDao = $this->dao->load('Core_Eiocontent');
			$trueList = $eioContentDao->listTrueAnswer($eioId);
            // 计算分数
			foreach ($trueList as $id=>$value){
				if(!strcmp($resultList[$id],$value))
					$score++;
			}
		}
		// 由分数区间判断所属范围levelABCD的相应信息
		$levelMessage = $eioDao->getLevelMessage($eioId,$score);
		$feedback = $score.'#'.$levelMessage;
		
		// 为用户加分
		$userDao = $this->dao->load('Core_User');
		$userDao -> addScore($this->user['id'] , $score);
		
		// 发表说说
		$blogDao = $this->dao->load('Core_Microblog');
		$eio = $eioDao->getEio($eioId);
		$eiotitle = $eio['title'];
		$content = $this->user['name']." 刚刚做了问卷 ".$eiotitle." ，赢得了".$score."积分！";
		$blogDao->create(array(
				'userid'	=> $this->user['id'],
				'content'	=> $content,
		));
		
		// 添加Eioresult,结果保存格式:用户结果(json字符串)#分数#反馈信息
		$merge = $result.'#'.$feedback;
		$eioresultDao = $this->dao->load('Core_Eioresult');
		$eioresultDao->create(array(
		        'userid' => $this->user['id'],
		        'eioid'  => $eioId,
		        'result' => $merge,
		));
		$this->render('10000','Dispose result OK',$feedback);
		
	}
	/**
	 *	use to test
	 */
	public function testAction()
	{
	    try {

	       /* $eioDao = $this->dao->load('Core_Eio');
	        echo $eioDao->getaLevelMessage(1,6);*/
	       print($heh);
	       //echo hello;
	       print(hello);
	    } catch (Exception $e) {
	    	echo 'get'.$e;
	        echo 'wrong';
	    }
	    
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：评论问卷接口
	 * <code>
	 * URL地址：/eio/comment
	 * 提交方式：post
	 * 参数#1：eioId，类型：INT，必须：YES
	 * 参数#2：cotent，类型：string，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 评论问卷接口
	 * @action /eio/comment
	 * @params eioId  1 INT
	 * @params cotent '' string
	 * @method post
	 */
	public function commentAction ()
	{
		$this->doAuth();
		
		try {
			$eioId = $this->param('eioId');
			$content = $this->param('cotent');
			$eiocommentDao = $this->dao->load('Core_Eiocomment');
			$eiocommentDao->addComment(
					$eioId,$this->user['id'],$content);
			
			$microBlogDao = $this->dao->load("Core_MicroBlog");
			$microBlogDao->addMicroBlog($this->user['id'], $content);
			
			$this->render('10000','Comment ok');
		} catch (Exception $e) {
			$this->render('14012', 'Comment failed! Error: '.$e->getMessage());
		}
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：踩一踩问卷接口
	 * <code>
	 * URL地址：/eio/stamp
	 * 提交方式：post
	 * 参数#1：eioId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 踩一踩问卷接口
	 * @action /eio/stamp
	 * @params eioId 1 INT
	 * @method post
	 */
	public function stampAction ()
	{
		$this->doAuth();
		
		try {
			$eioId = $this->param('eioId');
			
			$eioDao = $this->dao->load('Core_Eio');
			$eio = $eioDao->getEio($eioId);
			
			$eioDao -> stampEio($eioId);
			
			$content = $this->user['name']." 踩了".$eio['title']."调查问卷";
			$microBlogDao = $this->dao->load("Core_MicroBlog");
			$microBlogDao->addMicroBlog($this->user['id'], $content);
			
			$this->render('10000','Stamp eio ok');
		} catch (Exception $e) {
			$this->render('14012', 'Stamp eio failed! Error: '.$e->getMessage());
		}	
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：赞一赞问卷接口
	 * <code>
	 * URL地址：/eio/praise
	 * 提交方式：post
	 * 参数#1：eioId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 赞一赞问卷接口
	 * @action /eio/praise
	 * @params eioId 1 INT
	 * @method post
	 */
	public function praiseAction ()
	{
		$this->doAuth();
		
		try {
			$eioId = $this->param('eioId');
			$eioDao = $this->dao->load('Core_Eio');
			$eioDao -> praiseEio($eioId);
			$eio = $eioDao->getEio($eioId);
			$content = $this->user['name']." 赞了".$eio['title']."调查问卷！";
			$microBlogDao = $this->dao->load("Core_MicroBlog");
			$microBlogDao->addMicroBlog($this->user['id'], $content);
			$this->render('10000','Praise eio ok');
		} catch (Exception $e) {
			$this->render('14012', 'Praise eio failed! Error: '.$e->getMessage());
		}
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：获取做过的问卷列表接口
	 * <code>
	 * URL地址：/eio/myEioList
	 * 提交方式：post
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 获取做过的问卷列表接口
	 * @action /eio/myEioList
	 * @method post
	 */
	public function myEioListAction ()
	{
		$this->doAuth();
	
		try {
			$pageId = intval($this->param('pageId'));
			$userId =  $this->user['id'];
			$eioResultDao = $this->dao->load("Core_Eioresult");
			$eioDao = $this->dao->load("Core_Eio");
			$result = $eioResultDao->getEioListByUser($userId, $pageId);
			$list = array();
			if(is_array($result)){
				foreach ($result as $row) {
					if($row['eioid']){
						$eio = $eioDao->getEio($row['eioid']);
						array_push($list, $eio);
					}
				}
			}
			$this->render('10000','获取做过的问卷列表成功！',array(
				'myEioList'=>$list
			));
		} catch (Exception $e) {
			$this->render('14012', '获取做过的问卷列表失败! Error: '.$e->getMessage());
		}
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：获取做过的问卷结果接口
	 * <code>
	 * URL地址：/eio/myEioResult
	 * 提交方式：post
	 * 参数#1：eioId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 获取做过的问卷结果接口
	 * @action /eio/myEioResult
	 * @params eioid 
	 * @method post
	 */
	public function myEioResultAction ()
	{
		$this->doAuth();
	
		try {
			$eioid = $this->param('eioid');
			$userid = $this->user['id'];
			$eioResultDao = $this->dao->load('Core_Eioresult');
			$eioResult = $eioResultDao->getEioByEioId($userid, $eioid);
			$this->render('10000','获取做过的问卷结果成功！',array(
					'eioResult'=>$eioResult
			));
		} catch (Exception $e) {
			$this->render('14012', '获取做过的问卷结果失败！ Error: '.$e->getMessage());
		}
	}
}