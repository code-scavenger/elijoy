<?php
Class LoginController extends BaseController {
	/**
	 * ------------------------------------------------------
	 * 后台登录模板
	 * ------------------------------------------------------
	 * @param 		无
	 * @return 		admin模板
	 */
	public function getLogin() {
		//$data = array('dir' => getenv('pro_absolute_dir'));
		return View::make('login');
	}

	/**
	 * ------------------------------------------------------
	 * 后台登录入口
	 * ------------------------------------------------------
	 *
	 */
	public function postLogin() {
		
		$data = Input::all();
		if (Auth::attempt(array('name'=>$data['name'],
			'password'=>$data['password'])))
			return Redirect::to('/admin');
		else
			return Redirect::intended('/');
	}

	/**
	 * ------------------------------------------------------
	 * 登出应用
	 * ------------------------------------------------------
	 */
	public function getLogout() {
		if(Auth::check())
		{ 
			Auth::logout();
		}
		return Redirect::to('/login')->with('message','你现在已经退出登录了!'); 
	}

	/**
	 * ------------------------------------------------------
	 * 后台注册模板
	 * ------------------------------------------------------
	 */
	public function getEnroll() {
		// $data = array('dir' => getenv('pro_absolute_dir'));
		return View::make('enroll');
	}

	/**
	 * ------------------------------------------------------
	 * 后台注册入口
	 * ------------------------------------------------------
	 */
	public function postEnroll() {
		$timeString = explode(".", microtime());
		$namestr = str_replace(" ", "", $timeString[1]);
		$uniqueid = rand(10000, 30000).$namestr;

		$data = Input::all();
		if (DB::insert('insert into users (id, name, password) values (?, ?, ?)',
			array($uniqueid, $data['name'], Hash::make($data['password']))))
			return Redirect::to('/');
		else
			return Redirect::to('/enroll');
	}
}
?>