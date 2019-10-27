<?php 
require '../vendor/autoload.php';

use Muxinchao\UploadOne;

$file = $_FILES;
$obj = new UploadOne();
$res = $obj->uploadOne($file);
var_dump($res);