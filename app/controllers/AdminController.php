<?php
class AdminController extends BaseController {

	/**
	 * --------------------------------------------------------------
	 * 管理员首页，经测试，该接口正常
	 * 修改成功，未改变参数字段
	 * --------------------------------------------------------------
	 * 
	 * 请求路径： http://localhost/admin
	 * 请求方式：GET
	 *
	 * @return 管理员首页模板
	 */
	public function getIndex() { 
		
		$info = Project::get();
		$projects = DB::table('project')
						->get();
		return View::make('admin', [
					'info'=>$info,
					'projects'=>$projects
				]);
	}

	/**
	 * --------------------------------------------------------------
	 * 对应添加攻略浮层，经测试，该接口正常
	 * 修改成功，未改变参数字段
	 * --------------------------------------------------------------
	 * 
	 * 请求路径： http://localhost/addstr
	 * 请求方式：POST
	 *
	 * @param $_FILES['image'] 		图片文件
	 * @param $['styname'] 			攻略名字
	 * @param $data['articleid']  	攻略id
	 */
	public function postAddProject() {
		
		//$imgServer = App::make('imageProcess');
		// $logoinfo = $imgServer->uploadImageByName('logo');
		// $iconinfo = $imgServer->uploadImageByName('icon');
		$logoinfo = Input::get('logo');
		$iconinfo = Input::get('icon');
		$title = Input::get('styname');
		$idServer = App::make('uniqueProcess');
		$proid = $idServer -> produceUniqueId1();
		DB::insert("insert into project (id, title, logo, icon) values (?, ?, ?, ?)",
					array($proid, $title, $logoinfo, $iconinfo));
		$classes = explode(',', '完全攻略,游戏介绍,新闻资讯,今日推荐,开心图鉴');
		foreach ($classes as $entry) {
			$tmpId = $idServer->produceUniqueId1();
			DB::insert("insert into class (id, title, pro_id, intro) values (?, ?, ?,?)",
				array($tmpId, $entry, $proid, ''));
		}
		return Redirect::to('/admin');
		//return 'success';
	}

	public function getAddProject()
	{
		return Redirect::to('/admin');
	}
}
?>