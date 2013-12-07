<?php 
$_DataMap = array(
	
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
	
	'Microblog' => array(
		'id' => 'id',
		'userid' => 'userid',
		'name' => 'name',
		'content' => 'content',
		'uptime' => 'uptime',
	),

	'Image' => array(
		'id' => 'id',
		'url' => 'url',
		'type' => 'type',
	),
	'Notice' => array(
		'id' => 'id',
		'fromuserid' => 'fromuserid',
		'userid' => 'userid',
		'content' => 'content',
		'type' => 'type',
		'status' => 'status',
		'uptime' => 'uptime',
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