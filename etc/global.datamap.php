<?php 
$_DataMap = array(
	'User' => array(
		'id' => 'id',
		'sid' => 'sid',
		'name' => 'name',
		'sign' => 'sign',
		'face' => 'face',
		'faceurl' => 'faceurl',
		'sex' => 'sex',
		'birthday' => 'birthday',
		'location' => 'location',
		'eiocount' => 'eiocount',
		'fanscount' => 'fanscount',
		'score' => 'score',
		'uptime' => 'uptime',
	),	
	'Notice' => array(
		'id' => 'id',
		'fromuserid' => 'fromuserid',
		'fromname' => 'fromname',//// 
		'userid' => 'userid',
		'username' => 'username', ////
		'content' => 'content',
		'type' => 'type',
		'status' => 'status',
		'uptime' => 'uptime',
	),
	'Microblog' => array(
		'id' => 'id',
		'userid' => 'userid',
		'username' => 'username',
		'content' => 'content',
		'uptime' => 'uptime',
	),
	'Fans' => array(
		'id' => 'id',
		'name' => 'name',
		'sign' => 'sign',
		'face' => 'face',
		'faceurl' => 'faceurl',
		'sex' => 'sex',
		'birthday' => 'birthday',
		'location' => 'location',
		'eiocount' => 'eiocount',
		'fanscount' => 'fanscount',
		'score' => 'score',	 
	),
	'Classify' =>array(
		'id' =>'id',
		'name' =>'name',
		'icon' =>'icon',
		'uptime'=>'uptime',        
	),
	'Eio' =>array(
		'id' => 'id',
		'typeid' =>'typeid',
		'classifyid' =>'classifyid',
		'icon' => 'icon',
		'title' => 'title',
		'author' => 'author',
		'questioncount' => 'questioncount',
		'levelA' => 'levelA',
		'levelB' => 'levelB',
		'levelC' => 'levelC',
		'levelD' => 'levelD',
		'didcount' => 'didcount',
		'praisecount' => 'praisecount',
		'stampcount' => 'stampcount',
		'publishtime' => 'publishtime',
	),

	// 问卷问题的类型，对应了eiotype表
	'SimpleSelectQuestion' =>array( // 单项选择
		'id'=>'id',
		'eioid'=>'eioid',
		'questionnum' => 'questionnum',
		'question'=>'question',
		'answerA'=>'answerA',
		'answerB'=>'answerB',
		'answerC'=>'answerC',
		'answerD'=>'answerD',
		'trueanswer'=>'trueanswer',
	),
	'InputQuestion' =>array( 		// 填空
		'id'=>'id',
		'eioid'=>'eioid',
		'questionnum' => 'questionnum',
		'question'=>'question',
		'answerA'=>'answer',
	),
	'MultiSelectQuestion' =>array( // 多项选择
		'id'=>'id',
		'eioid'=>'eioid',
		'questionnum' => 'questionnum',
		'question'=>'question',
		'answerA'=>'answerA',
		'answerB'=>'answerB',
		'answerC'=>'answerC',
		'answerD'=>'answerD',
		'answerE'=>'answerE',
	),
	'EioResult' => array(
		'id'=>'id',
		'eioid'=>'eioid',
		'userid' => 'userid',
		'result' => 'result',
		'uptime' => 'uptime',
	),
	'QuestionResult' => array(
		'id' => 'id',
		'eiocontentid' => 'eiocontentid',
		'eioquestion' => 'eioquestion',
		'answer' => 'answer',
		'status' => 'status',
	),
	'Image' => array(
			'id' => 'id',
			'url' => 'url',
			'type' => 'type',
	),	
);

function M ($model, $data)
{
	global $_DataMap;
	
	$dataMap = isset($_DataMap[$model]) ? $_DataMap[$model] : null;
	if ($dataMap) {
		$dataRes = array();
		foreach ((array) $data as $k => $v) {
			if (array_key_exists($k, $dataMap)) {
				$mapKey = $dataMap[$k];
				$dataRes[$mapKey] = $v;
			}
		}
		return $dataRes;
	}
	
	return $data;
}