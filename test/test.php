<?php 
require '../vendor/autoload.php';

use Muxinchao\UploadOne;
use Muxinchao\UploadMore;

// echo 'aaa';
// $file = $_FILES;
// $obj = new UploadOne();
// $res = $obj->uploadOne($file);
// var_dump($res);

$file = $_FILES;
$obj = new UploadMore();
$res = $obj->uploadMore($file);
var_dump($res);