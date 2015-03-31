<?php
Class VisitController extends BaseController {

	//获取首页信息的接口！
	/**
	 * --------------------------------
	 * 获取项目分类
	 * 接口正常，前端正常
	 * --------------------------------
	 */
	public function getIndex($projectid) {

		//需要获得class名字
		$data['classes'] = DB::table('class')
			->where('class.pro_id', $projectid)
			->select('class.id', 'class.title', 'class.intro')
			->get();

		//获取项目信息
		$data['project'] = DB::table('project')
			->where('id', $projectid)
			->select('project.id', 'project.title', 'project.logo', 'project.icon')
			->get();
		if ($data['project']) {
			$data['project'] = $data['project'][0];
		} else {
			return "Wrong page";
		}

		return View::make('index', $data);
	}

	/**
	 * --------------------------------
	 * 获取分类下文章列表
	 * bug: 字符串截取存在乱码！
	 * --------------------------------
	 *
	 * @param 
	 */
	public function getArticles($classid) {

		$data['class'] = DB::table('class')
			->where('id', $classid)
			->select('id', 'title', 'intro', 'pro_id')
			->get();

		$data['articles'] = DB::table('article')
			// ->join('class', 'class.id', '=', 'article.cla_id')
			// ->join('images', 'images.id', '=', 'article.icon')
			->where('cla_id', $classid)
			// ->select('article.id', 'article.title', 'article.text', 'images.url')
			->get();

		//处理一下前端要用到的字符串
		// foreach ($data['articles'] as $key => $value) {
		// 	if (strlen($value->text) > 10) {
		// 		$value->text = show_text($value->text);
		// 	} else {
		// 		$value->text = $value->text."......";
		// 	}
		// }

		//$data['dir'] = getenv('pro_absolute_dir');

		return View::make('list-page', $data);
	}

	public function showArticle($articleid) {

		$data['article'] = DB::table('article')
			// ->join('images', 'images.id', '=', 'article.icon')
			->where('article.id', $articleid)
			// ->select('article.id', 'article.title', 'article.text',
			// 	'article.date', 'article.cla_id', 'images.url')
			->get();

		//$data['article'][0]->url = img_to_url($data['article'][0]->url);
		//$data['dir'] = getenv('pro_absolute_dir');
		return View::make('article-page', $data);
		//return '<html>'.var_dump($data).'</html>';
	}


	public function userLogin(){
		return View::make('login-page');
	}
	public function userAward(){
		return View::make('lipin-page');
	}
}
?>