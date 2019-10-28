<?php 
require '../vendor/autoload.php';

// use Muxinchao\UploadOne;
use Muxinchao\Upload;

// echo 'aaa';
// $file = $_FILES;
// $obj = new UploadOne();
// $res = $obj->uploadOne($file);
// var_dump($res);

$file = $_FILES;
$obj = new Upload();
$res = $obj->upload($file);
var_dump($res);