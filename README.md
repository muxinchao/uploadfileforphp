# uploadfileforphp

## 配置
	1.uploadfileforphp/config/default.php 

	2.allow_exts:允许上传文件后缀数组。

	3.path:上传文件保存位置，确保你的项目根目录要有写的权限

## 使用
1.安装包


	$ composer require muxinchao/uploadfileforphp:dev-master

2.在项目中使用


	use Muxinchao;
	$file = $_FILES;
	$obj = new Upload();
	$res = $obj->upload($file);
	var_dump($res);








