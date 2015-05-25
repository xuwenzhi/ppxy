<?php namespace App\Http\Controllers\Home;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Util;
use App\Services\Protocol;
use User;

class UserController extends HomeController {

	public function checkEmailRepeat(Request $request){
		$check_email = $request -> get('email');
		if(!$check_email || $check_email == ''){
			return Util::json_format(Protocol::ERROR, '数据加载失败,建议您刷新浏览器重试');
		}
		
	}

}
