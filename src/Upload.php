<?php 
namespace Muxinchao;

class Upload
{
	use PublicFunction;

	public function upload($file)
	{
		var_dump($file);
		$file = $this->getFileInfo($file);
		if (!$file) {
			return json_encode(['code' => 40005, 'message' => '没有上传文件']);
		}
		foreach ($file as $key => $value) {
			//获取错误信息
			if ($value['error'] > 0) {//等于0可以上传，大于0报出具体错误
				return json_encode(['code' => $value['error'], 'message' => '错误:' . $this->codeToMessage($value['error'])]);
			}
			//判断文件后缀
			$ext = $this->getAllowExts($value['name']);
			$allowedExtsArray = $this->getConfigAllowExts();
			if (empty($allowedExtsArray)) {
				return json_encode(['code' => 40002, 'message' => '请配置default.php中allow_exts的值']);
			}
			if (!in_array($ext, $allowedExtsArray)) {
				return json_encode(['code' => 40003, 'message' => '不允许上传的文件']);
			}
			$tmpName = $this->setNewFileName($value['name']);
			if (!$this->getRootDir()) {
				return json_encode(['code' => 40007, 'message' => '根目录不可写']);
			}
			$savePath = $this->makeDir($this->getSavePath());
			if (file_exists($savePath . '/' . $tmpName)) {
				return json_encode(['code' => 40004, 'message' => $value['name'].'文件已经上传']);
			}
			$result = move_uploaded_file($value["tmp_name"], $savePath . '/' . $tmpName);
			if (!$result) {
				return json_encode(['code' => 40006, 'message' => '上传失败']);
			}
			//释放临时文件
			unset($value['tmp_name']);
		}
		return json_encode(['code' => 40000, 'message' => '上传成功']);
	}
}
