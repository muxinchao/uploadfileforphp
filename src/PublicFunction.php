<?php 
namespace Muxinchao;

Trait PublicFunction
{
	/**
	 * 获取文件key值，返回对应value
	 * @$file $_FILES 数组信息
	 * @return 上传文件信息
	 */
	protected function getFileInfo($file)
	{
		if (is_array($file) &&  count($file) === 0) {
			return false;
		}
		if (is_array($file) && count($file) >= 1) {
			$newFile = [];
			foreach ($file as $key => $value) {
				$newFile[$key] = $value;
			}
			return $newFile;
		}
	}
	/**
	 * 获取配置文件default.php中允许上传的文件后缀名数组 
	 */
	protected function getConfigAllowExts()
	{
		if (file_exists('../config/default.php')) {
			$allowExts = include '../config/default.php';
			return $allowExts['allow_exts'];
		} 
		return [];
	}
	/**
	 * 获取上传文件后缀名
	 * @$fileName 上传文件名
	 */
	protected function getAllowExts($filename)
	{
		return substr(strchr($filename, '.'), 1);
	}
	/**
	 * 设置新文件名称 用来保存到本地
	 * @$fileName 上传文件名
	 */
	protected function setNewFileName($fileName)
	{
		return substr(md5($fileName), -7) . '.' . $this->getAllowExts($fileName);
	}
	/**
	 * 获取网站根目录
	 */
	protected function getRootDir()
	{
		//不可写返回错误
		if (!is_writable($_SERVER['DOCUMENT_ROOT'])) {
			return false;
		}
		return $_SERVER['DOCUMENT_ROOT'];
	}
	/**
	 * 获取保存路径
	 */
	protected function getSavePath()
	{
		if (file_exists('../config/default.php')) {
			$allowExts = include '../config/default.php';
			return $allowExts['path'];
		} 
	}
	/**
	 * 创建保存路径
	 */
	protected function makeDir($path)
	{
		if(empty($path)) {
			$path = '/uploadfiles/images';
		}
		//去掉收尾 / 正斜线
		$path = explode('/', trim($path, '/'));
		$pathStr = $this->getRootDir();
		foreach ($path as $key => $value) {
			if (!is_dir($pathStr . '/' . $value)) {
				mkdir($pathStr . '/' . $value);
				chmod($pathStr . '/' . $value, 0777);
				$pathStr = $pathStr . '/' . $value;
			} else {
				$pathStr = $pathStr . '/' . $value;
			}
		}
		return $pathStr;
	}

	/**
	 * 上传文件错误码 
	 */
	private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }

}