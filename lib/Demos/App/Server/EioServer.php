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
		
		$classifylist = array();
		$classifyDao = $this->dao->load("Core_Eioclassify");
		$classifylist = $classifyDao->getClassifyList();
		if ($classifylist) {
			$this->render('10000', 'Get classify list ok', array(
					'Classify.list' => $classifylist
			));
		}
		$this->render('14009', 'Get classify list failed');
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
		
		$classifyId = intval($this->param('classifyId'));
		$pageId = intval($this->param('pageId'));
		
		$eioList = array();
		$eioDao = $this->dao->load('Core_Eio');
		$eioList = $eioDao->getListByClassify($classifyId, $pageId);
		if ($eioList) {
			$this->render('10000', 'Get eio list ok', array(
					'Eio.list' => $eioList
			));
		}
		$this->render('14010', 'Get eio list failed');
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
		
		$name = $this->param('name');
		$pageId = intval($this->param('pageId'));
		
		$eioList = array();
		$eioDao = $this->dao->load('Core_Eio');
		$eioList = $eioDao->searchList($name, $pageId);
		if ($eioList) {
			$this->render('10000', 'Search eio list ok', array(
					'Eio.list' => $eioList
			));
		}
		$this->render('14011', 'Search eio list failed');
	}
    
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：获取问题列表接口
	 * <code>
	 * URL地址：/eio/quesList
	 * 提交方式：GET
	 * 参数#1：EIOId，类型：INT，必须：YES
	 * 参数#2：pageId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 获取问题列表接口
	 * @action /eio/quesList
	 * @params EIOId  1 INT
	 * @params pageId 0 INT
	 * @method get
	 */
	public function quesListAction ()
	{
		
	}
}
