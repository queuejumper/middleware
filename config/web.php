<?php
$urlManager = require('urlManager.php');
$params = require('params.php');

$config = [
	'urlManager' =>[
		'rules' => $urlManager,
		'showIndex' => true
	],
	'params' => $params,
];

return $config;