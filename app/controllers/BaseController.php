<?php

class BaseController extends Controller {

	/**
	 * 对所有的Controller进行验证
	 *
	 */
	/*public function __construct()
    {
        if(Auth::check() == false){
            return Redirect::guest('/');
        }
    }*/

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
