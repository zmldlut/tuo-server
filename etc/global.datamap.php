<?php 
$_DataMap = array(
	'user' => array(
		'id' => 'id',
		'sid' => 'sid',
		'name' => 'name',
		'sign' => 'sign',
		'face' => 'face',
		'sex' => 'sex',
		'birthday' => 'birthday',
		'location' => 'location',
		'faceurl' => 'faceurl',
		'eiocount' => 'eiocount',
		'fanscount' => 'fanscount',
		'score' => 'score',
	),
	'Comment' => array(
		'id' => 'id',
		'eioid' => 'eioid',
		'userid' => 'userid',
		'content' => 'content',
		'uptime' => 'uptime',
	),
	'eio' => array(
		'id' => 'id',
		'type' =>'type',
		'title' => 'title',
		'author' => 'author',
		'questioncount' => 'questioncount',
		'levelA' => 'levelA',
		'levelB' => 'levelB',
		'levelC' => 'levelC',
		'levelD' => 'levelD',
		'uptime' => 'uptime',
	),
	'Notice' => array(
		'id' => 'id',
		'message' => 'message'
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