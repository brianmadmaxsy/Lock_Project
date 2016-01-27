s<?php

class SampleController extends BaseController{

	public function index(){
		return View::make('content.content', array('name'=>'Brian'))
			->with('age','21')
			->with('gender','male');
	}
}


?>