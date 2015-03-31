<?php
class imageProcess {

	/**
	 * --------------------------------------------------------------
	 * 单张图片上传的接口
	 * --------------------------------------------------------------
	 * 
	 * @return image['name'] 	图片名字
	 * @return image['width'] 	图片宽度
	 * @return image['height']  图片高度
	 */
	public function uploadImage() {

		//利用毫秒时间重命名文件，时间：0.25139300 1138197510
		if (empty($_FILES['image']))
			return array('name'=>null, 'width'=>null, 'height'=>null);

		$timeString = explode(".", microtime());
		$namestr = str_replace(" ", "", $timeString[1]);
		$fileParts = explode(".", $_FILES['image']['name']);
		$_FILES['image']['name'] = $namestr.".".$fileParts[1];

		//拷贝图片到指定路径，
		$targetFile = getenv('server_images')."/".$_FILES['image']['name'];
		move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);

		$imageifno = getimagesize($targetFile);
		$image = array('name' => null, 'width' => null, 'height' => null);
		$imageinfo = getimagesize($targetFile);
		array_unshift($imageinfo, $_FILES['image']['name']);
		list($image['name'], $image['width'], $image['height'])
			= $imageinfo;
		return $image;
	}

	/**
	 * --------------------------------------------------------------
	 * 多张图片上传的接口
	 * 这个文件暂时不管了
	 * --------------------------------------------------------------
	 * 
	 * @return image[i]['name'] 	图片名字
	 * @return image[i]['width'] 	图片宽度
	 * @return image[i]['height']	图片高度
	 */
	public function uploadImages() {

		//利用毫秒时间重命名文件，时间：0.25139300 1138197510
		$timeString = explode(".", microtime());
		$namestr = str_replace(" ", "", $timeString[1]);

		$res = array();
		for ($i = 0; $i < count($_FILES['image']['name']); ++$i) {
			$fileParts = explode(".", $_FILES['image']['name'][$i]);
			$_FILES['image']['name'][$i] = 
				$namestr.rand(10000, 30000).".".$fileParts[1];
			$targetFile = getenv('server_images')."/".$_FILES['image']['name'][$i];
			move_uploaded_file($_FILES['image']['tmp_name'][$i], $targetFile);

			$image = array('name' => null, 'width' => null, 'height' => null);
			$imageinfo = getimagesize($targetFile);
			array_unshift($imageinfo, $_FILES['image']['name'][$i]);
			list($image['name'], $image['width'], $image['height'])
				= $imageinfo;
			array_push($res, $image);
		}

		return $res;
	}
	
	/**
	 * --------------------------------------------------------------
	 * 单张图片指定名字上传的接口
	 * --------------------------------------------------------------
	 * 
	 * @return image['name'] 	图片路径
	 * @return image['width'] 	图片宽度
	 * @return image['height']	图片高度
	 */
	public function uploadImageByName($name) {

		//利用毫秒时间重命名文件，时间：0.25139300 1138197510
		if (empty($_FILES[$name]))
			return array('name'=>null, 'width'=>null, 'height'=>null);

		$timeString = explode(".", microtime());
		$namestr = str_replace(" ", "", $timeString[1]);
		$fileParts = explode(".", $_FILES[$name]['name']);
		$_FILES[$name]['name'] = $namestr.".".$fileParts[1];

		//拷贝图片到指定路径，
		$targetFile = getenv('server_images')."/".$_FILES[$name]['name'];
		move_uploaded_file($_FILES[$name]['tmp_name'], $targetFile);

		$imageifno = getimagesize($targetFile);
		$image = array('name' => null, 'width' => null, 'height' => null);
		$imageinfo = getimagesize($targetFile);
		array_unshift($imageinfo, $_FILES[$name]['name']);
		list($image['name'], $image['width'], $image['height'])
			= $imageinfo;
		return $image;
	}

	/**
	 * --------------------------------------------------------------
	 * 删除指定路径图片
	 * --------------------------------------------------------------
	 * @param $targetFile 	图片路径
	 * 
	 * @return true 		删除成功
	 * @return false 		删除失败
	 */
	public function unlinkImage($targetFile) {
		return unlink($targetFile);
	}

	/*public function insertImage($table, $keyname, $filename) {
		$image = $this -> uploadImageByName($filename);
		$idServer = App::make('uniqueProcess');
		$imageid = $idServer->produceUniqueId1();
		DB::transaction(function() use($imageid, $image, $table, $keyname)
		{
			DB::insert('insert into image (id, url) values (?, ?)',
				$imageid, $image['url']);
			DB::table($table)
				->where($keyname, )
				->update();
		});
		//这里代码没有写完
	}*/
}
?>