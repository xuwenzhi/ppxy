<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Util;
use App\User;
use App\SmsVerifyRecord;
use App\OauthClients;
use App\OauthUsers;

class UserController extends ApiController {

	/**
	 * 发送验证码
	 */
	public function veirfyCode(Request $request){
		$phone_nu = $request->get('phone_nu');
		if(!Util::reg_phone_nu($phone_nu)){
			return $this->send(3);
		}
		if(User::checkPhoneRepeat($phone_nu)){
			return $this->send(4);
		}
		if(SmsVerifyRecord::TOP_USER < SmsVerifyRecord::getVerifyPhoneTimesByPhone($phone_nu)){
			return $this->send(5);
		}
		if(SmsVerifyRecord::apiGenerateSend(0, $phone_nu)){
			return $this->send(0);
		}
		return $this->send(6);
	}

	/**
	 * 通过手机验证码注册
	 */
	public function doVerify(Request $request){
		$phone_nu    = $request->get('phone_nu');
		$verify_code = $request->get('verify_code');
		if(!Util::reg_phone_nu($phone_nu) || !Util::reg_verify_code($verify_code)){
			return $this->send(7);
		}
		if(User::checkPhoneRepeat($phone_nu)){
			return $this->send(4);
		}
		$verify_record = SmsVerifyRecord::apiCheckUserVerify($verify_code, $phone_nu);
		if($verify_record){
			//验证通过,注册该用户
			$newUid = User::apiAddUser(array('phone_nu'=>$phone_nu));
			if($newUid){
				OauthUsers::insert(array('email'=>'', 'password'=>'', 'phone'=>$phone_nu));
				OauthClients::insert(array('client_id'=>'', 'client_secret'=>'', 'phone'=>$phone_nu, 'user_id'=>$newUid));
				return $this->send(0);
			} else {
				return $this->send(7);
			}
		}else{
			return $this->send(7);
		}
		return $this->send(8);
	}

	/**
	 * 添加密码
	 */
	public function addPassword(Request $request){

	}

}
