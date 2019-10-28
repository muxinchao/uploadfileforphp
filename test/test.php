<?php 
require '../vendor/autoload.php';

use Muxinchao\Upload;

$file = $_FILES;
$obj = new Upload();
$res = $obj->upload($file);
var_dump($res);