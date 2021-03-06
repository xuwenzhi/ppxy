<?php namespace App\Http\Controllers\Home;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Util;
use App\Services\Protocol;
use App\User;
use App\OauthUsers;
use App\OauthClients;
class UserController extends Controller {

	public function checkEmailRepeat(Request $request){
		$check_email = $request -> get('email');
		if(!$check_email || $check_email == ''){
			return Util::json_format(Protocol::JSEND_ERROR, '数据加载失败,建议您刷新浏览器重试');
		}
		$db_email_count = User::where(array('email' => $check_email)) -> count();
		if($db_email_count){
			return Util::json_format(Protocol::JSEND_SUCCESS, '', $db_email_count);
		}
		return Util::json_format(Protocol::JSEND_SUCCESS, '', array('count' => 0));
	}

	public function updateUserPass(Request $request){
		$email = $request->get('email');
		$password = $request->get('password');
		if(!$email || !$password || $email == '' || $password == ''){
			return Util::json_format(Protocol::JSEND_ERROR, '您提交的信息有误,请重试！');
		}
		return Util::json_format(Protocol::JSEND_SUCCESS, '');
	}

}
