<?php namespace App\Http\Controllers\Home;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
class IndividualController extends HomeController {

	/**
	 * 个人主页 
	 */
	public function page($username){
		$username =trim($username);
		if(!$username){
			return Redirect::to('/404');
		}
		$arrUser = User::where(array('name'=>$username))->get();
		$arrUser = $arrUser[0];
		$data = array(
			'baseinfo' =>$arrUser,
		);
		return view('app.individual.center', $data);
	}

	/**
	 * 个人设置
	 */
	public function setting(){
		$arrUser = $this -> getLogUser();
		if(!$arrUser){
			return Redirect::to('/auth/login');
		}
		$data = array(
			'baseinfo' => $arrUser,
			'role_pending' => User::ROLE_PENDING,
		);
		return view('app.individual.verifyphone', $data);
	}

}
