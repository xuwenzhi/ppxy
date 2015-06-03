<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Util;
use Illuminate\Support\Facades\Redirect;

class UserController extends AdminController {
	/**
	 * 所有用户列表
	 */
	public function userall(){
		if(!$this->checkRole()){
			return Redirect::to('/error');
		}
		$arrUsers = User::paginate($this->intPageSize);
		$data = array(
        	'users' => $arrUsers,
        	'title' => '用户列表',
	    );
	    return view('admin.user.userlist', $data);
	}

	/**
	 * 今日用户
	 */
	public function today(){
		if(!$this->checkRole()){
			return Redirect::to('/error');
		}
		$strDateStart = date('Y-m-d 00:00:00');
		$strDateEnd   = date('Y-m-d 23:59:59');
		$arrUsers = User::whereBetween("created_at", array($strDateStart, $strDateEnd))->paginate($this->intPageSize);
		$data = array(
        	'users' => $arrUsers,
        	'title' => '今日用户',
	    );
	    return view('admin.user.userlist', $data);
	}

	/**
	 * 未认证用户
	 */
	public function pending(){
		if(!$this->checkRole()){
			return Redirect::to('/error');
		}
		$strDateStart = date('Y-m-d 00:00:00');
		$strDateEnd   = date('Y-m-d 23:59:59');
		$arrUsers = User::where(array('role' => User::ROLE_PENDING))->paginate($this->intPageSize);
		$data = array(
        	'users' => $arrUsers,
        	'title' => '未认证用户',
	    );
	    return view('admin.user.userlist', $data);
	}

	public function member(){
		if(!$this->checkRole()){
			return Redirect::to('/error');
		}
		$strDateStart = date('Y-m-d 00:00:00');
		$strDateEnd   = date('Y-m-d 23:59:59');
		$arrUsers = User::where(array('role' => User::ROLE_MEMBER))->paginate($this->intPageSize);
		$data = array(
        	'users' => $arrUsers,
        	'title' => '已认证用户',
	    );
	    return view('admin.user.userlist', $data);
	}

	public function detail($enId){
		if(!$this->checkRole()){
			return Redirect::to('/error');
		}
		$id = Util::encryptData($enId, true);
		echo $id;
	}


}
