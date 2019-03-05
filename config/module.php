<?php
$directory = __DIR__.'/../app/Modules/';
$folder = glob($directory . "*", GLOB_ONLYDIR );

$data = array();
foreach ($folder as $file) {
	$a = explode("/", $file);
	$b = array();
	$b = end($a);
	$data[] = $b;
}

$result = [
		    'modules' => $data
		];

return  $result;
