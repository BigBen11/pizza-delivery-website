<?php

$myArray = ['name' => 'Thomas', 'alter' => 34 ];
$myJsonString = json_encode($myArray);
header('Content-Type: application/json');
echo $myJsonString;