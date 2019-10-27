<?php 
namespace Muxinchao;

class UploadOne
{
	protected $fileName;

	protected $allowedExts = ['jpg', 'gif'];

	protected function getFileName($file)
	{
		if (is_array($file) && count($file) === 1) {
			foreach ($file as $key => $value) {
				$this->fileName = $key;
			}
			return $file[$this->fileName];
		} 
		return false;
	}
	protected function getAllowExts($name)
	{
		$ext = substr(strchr($name, '.'), 1);
		return $ext;
	}

	public function uploadOne($file)
	{
		//获取上传文件信息
		$file = $this->getFileName($file);
		if (!$file) {
			return json_encode(['code' => 40001, 'message' => '您没有上传文件或者上传多个文件']);
		}
		//获取错误信息
		if ($file['error'] > 0) {
			return json_encode(['code' => 40002, 'message' => '错误:' . $file['error']]);
		}
		//判断文件后缀
		$ext = $this->getAllowExts($file['name']);
		if (!in_array($ext, $this->allowedExts)) {
			return json_encode(['code' => 40003, 'message' => '不允许上传的文件']);
		}
		$tmpName = substr(md5($file['name']), -7) . '.' . $ext;
		$path =  $_SERVER['DOCUMENT_ROOT'];
		if (file_exists($path . '/public/images/' . $tmpName)) {
			return json_encode(['code' => 40004, 'message' => '文件已经上传']);
		}
		if (is_dir($path . '/public')) {
			if (is_dir($path . '/public/images')) {
				move_uploaded_file($file["tmp_name"], $path . "/public/images/" . $tmpName);
				return json_encode(['code' => 40000, 'message' => '上传成功']);
			} else {
				mkdir($path . '/public/images', 0777);
				move_uploaded_file($file["tmp_name"], $path . "/public/images/" . $tmpName);
				return json_encode(['code' => 40000, 'message' => '上传成功']);
			}
		} else {
			//创建文件夹
			mkdir($path . '/public/images', 0777, true);
			move_uploaded_file($file["tmp_name"], $path . "/public/images/" . $tmpName);
			return json_encode(['code' => 40000, 'message' => '上传成功']);
		}
	}
}
