<?php 
namespace Muxinchao;

class UploadMore
{
	use PublicFunction;

	// protected $allowedExts = ['jpg', 'gif'];

	// protected function getFileName($file)
	// {
	// 	if (is_array($file) && (count($file) === 1 || count($file) === 0)) {
	// 		return false;
	// 	}
	// 	$newFile = [];
	// 	foreach ($file as $key => $value) {
	// 		$newFile[$key] = $value;
	// 	}
	// 	return $newFile;
	// }
	// protected function getAllowExts($name)
	// {
	// 	$ext = substr(strchr($name, '.'), 1);
	// 	return $ext;
	// }

	public function uploadMore($file)
	{
		$file = $this->getFileInfo($file);
		if (!$file) {
			return json_encode(['code' => 40005, 'message' => '只允许上传多个文件']);
		}
		foreach ($file as $key => $value) {
			//获取错误信息
			if ($value['error'] > 0) {
				return json_encode(['code' => 40002, 'message' => '错误:' . $file['error']]);
			}
			//判断文件后缀
			$ext = $this->getAllowExts($value['name']);
			$allowedExtsArray = $this->getConfigAllowExts();
			if (!in_array($ext, $allowedExtsArray)) {
				return json_encode(['code' => 40003, 'message' => '不允许上传的文件']);
			}
			$tmpName = $this->setNewFileName($value['name']);
			$path =  $this->getRootDir();
			echo $this->makeDir('/public/images/');
			die('aaa');
			if (file_exists($path . '/public/images/' . $tmpName)) {
				return json_encode(['code' => 40004, 'message' => $value['name'].'文件已经上传']);
			}
			if (is_dir($path . '/public')) {
				if (is_dir($path . '/public/images')) {
					$result = move_uploaded_file($value["tmp_name"], $path . "/public/images/" . $tmpName);
					if (!$result) {
						return json_encode(['code' => 40006, 'message' => '上传失败']);
					}
				} else {
					mkdir($path . '/public/images', 0777);
					$result = move_uploaded_file($value["tmp_name"], $path . "/public/images/" . $tmpName);
					if (!$result) {
						return json_encode(['code' => 40006, 'message' => '上传失败']);
					}
				}
			} else {
				//创建文件夹
				mkdir($path . '/public/images', 0777, true);
				$result = move_uploaded_file($value["tmp_name"], $path . "/public/images/" . $tmpName);
				if (!$result) {
						return json_encode(['code' => 40006, 'message' => '上传失败']);
				}
				return json_encode(['code' => 40000, 'message' => '上传成功']);
			}
		}
	}
}
