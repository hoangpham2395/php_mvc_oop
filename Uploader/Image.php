<?php 
class Uploader_Image {

	public function checkImage ($img = []) 
	{
		return (!empty($img['name'])) ? true : false;
	}

	public function saveImageToTempFolder ($img = []) 
	{
		$tmp_path = 'uploads/tmp/'.$img['name'];
		// Save to temporary folder
		move_uploaded_file($img['tmp_name'], 'uploads/tmp/'.$img['name']);
	}

	public function uploadImage ($type, $img = []) 
	{
		$img_name = $type.'_'.$img['name'];
		$img_path = 'uploads/images/'.$img_name;
		$tmp_path = 'uploads/tmp/'.$img['name'];
		// Save image from temporary folder to uploads folder
		return rename($tmp_path, $img_path);
	}

	public function deleteImage ($img) 
	{
		if (!empty($img) && file_exists('uploads/images/'.$img)) {
			unlink('uploads/images/'.$img);
		} 
	}
}
?>