<?php namespace App\Http\Controllers\Home;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Util;
use App\SmsVerifyRecord;

class IndividualController extends HomeController {

	//由哪几个类型跳转到的验证手机号
	const RESOURCE_TYPE_NEWGOODS = 'newgoods';
	const RESOURCE_TYPE_BUYGOODS = 'buygoods';
	const RESOURCE_TYPE_NOTHING  = 'default';

	public static $verify_reason = array(
		self::RESOURCE_TYPE_NEWGOODS => '您首先需要验证手机号,这样保证了买家可以联系到您。请放心,没有诚意购买的买家,我们不会提供给TA您的手机号。',
		self::RESOURCE_TYPE_BUYGOODS => '您首先需要验证手机号,这样保证了卖家可以联系到您。',
		self::RESOURCE_TYPE_NOTHING  => '',
	);

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
	public function setting($resource){
		$verify_information = '';
		if(!empty($resource) && $resource != ''){
			$verify_information = '';
			$verify_reason = self::$verify_reason;
			if(isset($verify_reason[$resource])){
				$verify_information = $verify_reason[$resource];
			}
		}
		$arrUser = $this -> getLogUser();
		if(!$arrUser){
			return Redirect::to('/auth/login');
		}
		$arrUser['phone_nu'] = Util::mask_phone_nu($arrUser['phone_nu']);
		$data = array(
			'baseinfo' => $arrUser,
			'role_pending'  => User::ROLE_PENDING,
			'url_back' 		=> $this->getPreviousUrl(),
			'verify_reason' => $verify_information,
		);
		return view('app.individual.verifyphone', $data);
	}

	/**
	 * 获取短信验证码
	 */
	public function verifyphone(Request $request){
		$strPhoneNu = $request->get('phone_nu');
		if(!Util::reg_phone_nu($strPhoneNu)){
			return Util::json_format('error', '您的手机号格式错误，请重试!');
		}
		$arrUser = $this->getLogUser();
		if(!$arrUser){
			return Util::json_format('error', '您的登录已过期,请重新登录!');
		}
		//检查该手机号之前是否已经验证
		if(User::checkPhoneRepeat($strPhoneNu)){
			return Util::json_format('error', '该手机号已验证过了,请您更换其他手机号!');	
		}
		//检查该用户今天的请求次数
		if(SmsVerifyRecord::TOP_USER < SmsVerifyRecord::getVerifyPhoneTimesByUid($arrUser['id'])){
			return Util::json_format('error', '您今日的验证次数已达上限,请明日再试,多谢配合!');
		}
		//SmsVerifyRecord::generateSend($arrUser['id'], $strPhoneNu);
		return Util::json_format('success');
	}

	/**
	 * 提交验证码，执行验证
	 */
	public function doverifyphone(Request $request){

		$arrUser = $this->getLogUser();
		if(!$arrUser){
			return Util::json_format('error', '您的登录已过期,请重新登录!');
		}
		$phone_nu    = $request->get('phone_nu');
		$verify_code = $request->get('verify_code');
		if(!Util::reg_phone_nu($phone_nu) || !Util::reg_verify_code($verify_code)){
			return Util::json_format('error', '您的手机号或验证码格式错误,请重试!');
		}
		if($arrUser['role'] == User::ROLE_MEMBER){
			return Util::json_format('repeat', '您已经是验证用户了，不需要再从新验证');	
		}
		$verify_record = SmsVerifyRecord::checkUserVerify($arrUser['id'], $verify_code, $phone_nu);
		if($verify_record){
			//验证通过
			$resPass = User::passUserVerify($arrUser['id'], $phone_nu);
			if($resPass){
				return Util::json_format('success', '恭喜您通过验证，您将可以正常交易！');
			}else{
				return Util::json_format('error', '很抱歉，验证没有通过，请重试！');
			}
		}else{
			return Util::json_format('error', '验证码错误,请您重试!');
		}
		return Util::json_format('error', '系统错误,请重试!');
	}


}
