<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * 前端路由！
 */
Route::get('/user_index/{projectid}', "IndexController@getIndex");


/**
 * ----------------------------------------------------------------------
 * 后台路由注册区域
 * ----------------------------------------------------------------------
 */
Route::get('/',	"LoginController@getLogin");
Route::get('/login', 'LoginController@getLogin');
Route::get('/logout', 'LoginController@getLogout');
Route::post('/enroll', 'LoginController@postEnroll');
Route::get('/enroll', 'LoginController@getEnroll');
Route::post('/login', 'LoginController@postLogin');

// 路由表需要校对
Route::group(array('before' => 'auth'), function()
{
	Route::controller('admin', 'AdminController');
	// Route::controller("editor", "EditorController");
	// Route::get('/admin', 'AdminController@getIndex');
	// Route::post('/addstr', 'AdminController@addProject');

	//编辑页首页路由
	Route::get('/editor/{projectid}', 'EditorController@getIndex');

	//文章接口路由
	Route::post('/article', 'EditorController@getArticle');
	Route::post('/save', 'EditorController@saveArticle');
	Route::post('/new', 'EditorController@newArticle');
	Route::post('/remove', 'EditorController@removeArticle');

	//项目接口路由
	Route::post('/update', 'EditorController@updateProject');
	Route::post('/addpro', 'EditorController@addProject');

	//关于class的路由
	Route::post('/addcla', 'EditorController@addClass');
	Route::post('/renamecla', 'EditorController@renameClass');
	Route::post('/delcla', 'EditorController@delClass');

	//测试用路由
	Route::get('/test',	'AdminController@tmpTest');
	Route::post('/test', 'AdminController@tmpTest');
});

//测试路由，用于删除数据！
Route::get('clean', 'EditorController@remove');
Route::post('showarticle', 'EditorController@showArticle');

//前端用户访问页面的url
Route::get('/list-class/{projectid}', 'VisitController@getIndex');
Route::get('/list-article/{classid}', 'VisitController@getArticles');
Route::get('/article-page/{articleid}', 'VisitController@showArticle');
Route::get('/user-award', 'VisitController@userAward');
Route::Get('/user-login', 'VisitController@userLogin');