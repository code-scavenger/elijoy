<?php
class EditorController extends BaseController {

	/**
	 * --------------------------------------------
	 * 前端的编辑分类，也就是编辑项目
	 * 经查：确实需要一个projectid
	 * 修改成功，未改变参数字段！
	 * bug： 当文章icon为空是，因为无法join表image，至结果为空
	 * --------------------------------------------
	 * 
	 * 请求路径： http://localhost/editor/项目id
	 * 请求方式：GET
	 *
	 * 从前端接收的参数
	 * @param 	$projectid  	项目id
	 * 
	 * 返回前端的数据
	 * @send 	$classes 	[二维][‘id’, ‘title’, 'intro']			项目下面的类别
	 * @send 	$articles 	[二维][‘id’, ‘title’, ‘text’, ‘url’]	类别下面的文章
	 * @send 	$project 	[‘id’, ‘title’] 						项目信息(id, title) 					
	 * @send 	$dir 	 	url路径前缀
	 *
	 * 返回前端的模板
	 * @return 编辑页的模板 
	 */
	public function getIndex($projectid) {

		//需要获得class名字
		$data['classes'] = DB::table('class')
			->where('pro_id', $projectid)
			->get();

		//基于classes和projectid！获取分类！
		$data['articles'] = array();

		for ($i = 0; $i < count($data['classes']); $i++) {
			$data['articles'][$i] = DB::table('article')
				->where("article.cla_id", $data['classes'][$i]->id)
				->get();
		}
		//echo var_dump($data);
		$data['projects'] = DB::table('project')
			->where('project.id', $projectid)
			->select('project.id', 'project.title')
			->get();

		// $data['dir'] = getenv('pro_absolute_dir');
		$data['projectid'] = $projectid;
		

		//return "<html>".var_dump($data)."</html>";
		return View::make('editor', $data);
	}

	/**
	 * --------------------------------------------
	 * 前端的点击"编辑"文章， 获取文章的信息
	 * 数据格式: 对像格式，经测试，该接口正常
	 * 是否可以用子查询来优化
	 * 修改成功，未改变参数字段！
	 * bug: 图片icon没有保持完整，导致查询失败！！
	 * --------------------------------------------
	 * 
	 * 请求路径：http://localhost/article
	 * 请求方式：POST
	 *
	 * 从前端接收的参数
	 * @param $data['articleid'] 	文章对应的id
	 * 
	 * 发送给前端的参数
	 * @return  (id, title, text, imgid, url)   文章信息
	 */
	public function getArticle() {
		
		//$data['articleid'] = '17517272567001427131903';
		$articleid = Input::get('articleid');
		$atcinfo = DB::table('article')
			// ->join('images', 'article.icon', '=', 'images.id')
			->where('id', $articleid)
			->get();

		return json_encode($atcinfo[0]);
	}

	/**
	 * --------------------------------------------
	 * 前端在编辑页通过复层更新项目信息
	 * 经测试，该接口工作正常，前端存在乱码
	 * 修改成功，未改变参数字段！
	 * --------------------------------------------
	 * 
	 * 请求路径：http://localhost/update
	 * 请求方式：POST
	 *
	 * 从前端接收的参数
	 * @param $data['projectid'] 	项目对应的id
	 * @param $data['newname']		项目新的名字子
	 * @param $_FILES['logo'] 		项目的logo
	 * @param $_FILES['icon']		项目的icon
	 *
	 * 发送给前端的参数
	 * @send 无参数，直接后台重定向到本页！
	 */
	public function updateProject() {

		$data = Input::all();
		if (isset($data['logo'])) {
			DB::transaction(function() use ($data)
			{
				$url = DB::table('project')
					->join('images', 'project.logo', '=', 'images.id')
					->where('project.id', $data['projectid'])
					->select('images.url', 'images.id')
					->get();

				// unlink(getenv('server_images')."/".$url[0]->url);
				// move_uploaded_file($_FILES['logo']['tmp_name'],
				// 	getenv('server_images')."/".$url[0]->url);
			});
		}

		if (isset($data['icon'])) {
			DB::transaction(function() use ($data)
			{
				$url = DB::table('project')
					->join('images', 'project.icon', '=', 'images.id')
					->where('project.id', $data['projectid'])
					->select('images.url', 'images.id')
					->get();
				// unlink(getenv('server_images')."/".$url[0]->url);
				// move_uploaded_file($_FILES['icon']['tmp_name'],
				// 	getenv('server_images')."/".$url[0]->url);
			});
		}

		DB::table('project')
			->where('project.id', $data['projectid'])
			->update(array('title' => $data['newname']));

		return Redirect::to('/admin');
	}

	/**
	 * --------------------------------------------
	 * 前端点击保存文件
	 * bug: 
	 *		1、前提，所有的图片都存在，不存在url为空
	 * 		2、保存图片名字，可提高提高系统的可迁移性
	 * 修改成功，未改变参数字段！
	 * --------------------------------------------
	 * 
	 * 请求路径：http://localhost/save
	 * 请求方式：POST
	 *
	 * 从前端接收的参数
	 * @param $data['projectid'] 	项目id    
	 * @param $data['articleid'] 	文章对应的id
	 * @param $data['newname']		文章对应的新名字
	 * @param $data['content']		文章新的内容
	 * @param $data['icon'] 		全局文件变量该字节可能不存在
	 *
	 * 发送给前端的参数
	 * @send 无参数，直接后台重定向到本页！
	 */
	public function saveArticle() {
	
		$data = Input::all();
		$article = Article::find($data['articleid']);
		$article->title = $data['newname'];
		$article->text = $data['content'];
		$article->icon = $data['icon'];	
		$article->save();
		// DB::table('article')
		// 		->where('article.id', (string)$data['articleid'])
		// 		->update(array(
		// 			'title' => (string)$data['newname'],
		// 			'text' => (string)$data['content'],
		// 			'icon' => $data['icon'],

		// 		));

		return "true";
		//return Redirect::to('/admin');
		//$response = array('a'=>$data['projectid']);
		//这里需要重定向！前面不是ajax
		//return json_encode($response1 && $response2);
		// return Redirect::to('/editor/'.$data['projectid']);
		//以下带参数的跳转，方便前端把哪个页面至于第一位！
		// return Redirect::to('/editor/'.$data['projectid']);
		//return json_encode($response);
	}

	/**
	 * --------------------------------------------
	 * 前端新增一个文章，前端信息必须完整
	 * 经测试，该接口工作正常
	 * 修改成功，改变参数字段content
	 * --------------------------------------------
	 *
	 * 请求路径：http://localhost/new
	 * 请求方式：POST
	 *
	 * 发送给前端的参数
	 * @param 	$data['projectid'] 		项目id
	 * @param 	$data['classid'] 		类别id
	 * @param 	$data['title'] 			文章标题
	 * @param 	$_FILES['icon'] 		文章对应的icon
	 * 
	 * @send 无参数，直接后台重定向到本页！
	 */
	public function newArticle() {

		$data = Input::all();
		$idServer = App::make('uniqueProcess');
		$articleid = $idServer->produceUniqueId1();

		DB::insert('insert into article
			(id, title, date, icon, cla_id, text) values (?, ?, ?, ?, ?, ?)',
			array($articleid, $data['title'], date("Y-m-d"), $data['icon'], $data['classid'], ""));

		return Redirect::to('/editor/'.$data['projectid']);
	}

	/**
	 * --------------------------------------------
	 * 删除文章，对应前端删除文章接口！
	 * ajax接口！
	 * --------------------------------------------
	 *
	 * @param 	$data['articleid'] 	 	文章Id
	 */
	public function removeArticle() {
		$data = Input::all();
		DB::table('article')
			->where('id', $data['articleid'])
			->delete();
		return 'success';
	}

	/**
	 * --------------------------------------------
	 * 添加一个分类，忘记了确认一下数据库是否有这个记录
	 * 有则只做操作关联表!
	 * 经测试，该接口工作正常
	 * 删除和重命名都要对class新增字段进行加减操作
	 * 测试失败！
	 * --------------------------------------------
	 *
	 * 请求路径：http://localhost/addcla
	 * 请求方式：POST
	 *
	 * @param $data['claname'] 		分类对应的名字
	 * @param $data['intro'] 		分类的描述
	 * @param $data['projectid']	项目id
	 * 
	 * 这个接口需要ajax返回！
	 * @send 无参数，直接后台重定向到本页！
	 */
	public function addClass() {
		$data = Input::all();
		//return $data;
		$idServer = App::make('uniqueProcess');
		$classid = $idServer->produceUniqueId1();

		$classinfo = DB::table('class')
			->where('title', $data['claname'])
			->where('pro_id', $data['projectid'])
		 	->select()
		 	->get();
		//return $data['claname'].' '.$data['projectid'];

		if (empty($classinfo)) {
		 	DB::insert('insert into class (id, title, intro, pro_id) values (?, ?, ?, ?)',
		 		array($classid, $data['claname'], $data['intro'], $data['projectid']));
		 	return json_encode(array('classid'=>$classid, 'claname'=>$data['claname']));
		} else
			return 'false';

		//return Redirect::to('/editor/'.$data['projectid']);
	}

	/**
	 * --------------------------------------------
	 * 重命名一个分类, stop here!，该接口未测试
	 * 经测试，该接口工作正常！
	 *  前提，这个class是一定存在！并且名字不可重复
	 * 修改成功，未修改参数字段
	 * --------------------------------------------
	 *
	 * 请求路径：http://localhost/renamecla
	 * 请求方式：POST
	 *
	 * @param $data['projectid'] 该类所属的projectid
	 * @param $data['classid']  分类对应的id
	 * @param $data['newname'] 	信的分类的名字
	 *
	 * @send 无参数，直接后台重定向到本页！
	 */
	public function renameClass() {

		$data = Input::all();

		DB::table('class')
			->where('id', $data['classid'])
			->update(array(
				'title'=>$data['title'], 
				'intro'=>$data['intro'])
			);

		// return Redirect::to('editor/'.$data['projectid']);
		return "success";
	}

	/**
	 * --------------------------------------------
	 * 删除分类，及分类下所有的文章
	 * 经测试，该接口工作正常！
	 * 修改成功，未修改参数字段
	 * --------------------------------------------
	 *
	 * 请求路径：http://localhost/delcla
	 * 请求方式：POST
	 *
	 * @param $data['projectid'] 项目id
	 * @param $data['classid']  类对应的id
	 * 
	 * @send 无参数，直接后台重定向到本页！
	 */
	public function delClass() {

		$data = Input::all();
		DB::transaction(function () use($data)
		{
			DB::table('article')
				->where('cla_id', $data['classid'])
				->delete();
			DB::table('class')
				->where('id', $data['classid'])
				->delete();
		});

		// return Redirect::to('/editor/'.$data['projectid']);
		return "success";
	}

	public function remove() {
		// DB::table('pro_to_cla')
		// 	->whereRaw('project_id = 2 and class_id = 20275230561001426839891')
		// 	->update(array('class_id'=>'20855666178001426837340'));
		// DB::insert('insert into article (id, name) values (?, ?)',
		// 	array(1, 'Dayle'));
		
	}

	// public function showArticle() {
	// 	$data = Input::all();
	// 	$info = DB::table('article')
	// 		->where('id', $data['articleid'])
	// 		->select('id', 'text')
	// 		->get();
	// 	return '<html><body>'.$info[0]->text.'</body></html>';
	// }
}
?>