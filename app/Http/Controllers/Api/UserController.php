<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Util;

class UserController extends ApiController {

	/**
	 * 发送验证码
	 */
	public function veirfyCode(Request $request){
		$phone_nu = $request->get('phone_nu');
		if(!Util::reg_phone_nu($phone_nu)){
			return Util::json_format('error', '您的手机号格式错误，请重试!');
		}
	}

	/**
	 * 通过手机验证码注册
	 */
	public function doVerify(Request $request){

	}

	/**
	 * 添加密码
	 */
	public function addPassword(Request $request){

	}

}
