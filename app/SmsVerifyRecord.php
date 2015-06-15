<?php 
/**
 * 短信验证码记录
 */
namespace App;
use App\Services\Sms;
use Illuminate\Support\Facades\Log;
class SmsVerifyRecord extends Base {

	const TYPE_USER = 'user';
	const TOP_USER  = 10;//最高一天5次
	const VALID_TIME = 1800;

	const TYPE_ORDER = 'order';
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sms_record';

	public $timestamps = false;

	/**
	 * 返回随机验证码
	 */
	public static function generateRandCode(){
		$randCode = rand(100000, 999998);
		return $randCode;
	}

	/**
	 * 获取某个手机号今天已经请求了多少次注册验证码
	 */
	public static function getVerifyPhoneTimesByUid($phone_nu){
		$strDateStart = date('Y-m-d 00:00:00');
		$strDateEnd   = date('Y-m-d 23:59:59');
		$intCount = SmsVerifyRecord::whereBetween("ctime", array($strDateStart, $strDateEnd))
			->where(array('phone_nu' =>$phone_nu, 'type' => self::TYPE_USER))
			->count();
		return $intCount;
	}

	/**
	 * 获取该用户今天已经请求了多少次验证手机号的验证码
	 */
	public static function getVerifyPhoneTimesByUid($uid){
		$strDateStart = date('Y-m-d 00:00:00');
		$strDateEnd   = date('Y-m-d 23:59:59');
		$intCount = SmsVerifyRecord::whereBetween("ctime", array($strDateStart, $strDateEnd))
			->where(array('uid' =>$uid, 'type' => self::TYPE_USER))
			->count();
		return $intCount;
	}

	public static function generateSend($uid, $phone_nu){
		$randCode = self::generateRandCode();
		$msg = sprintf("您本次的验证码为%s，请注意保密，感谢您的选择！", $randCode);
		$objSms = new Sms;
		$sendRes = $objSms->setHp($phone_nu)->setMsg($msg)->sendSingle();
		Log::info("【用户验证手机号】- 用户ID ".$uid." 手机号 ".$phone_nu.",短信内容为:".$msg);
		if($sendRes != 0){
			Log::error("【用户验证手机号短信发送失败】- 用户ID ".$uid." 手机号 ".$phone_nu.",短信内容为:".$msg);
		}
		//记录日志
		self::addRecord($uid, $randCode, $msg, $phone_nu, self::TYPE_USER);
		return $sendRes;
	}

	public static function checkUserVerify($uid, $code, $phone_nu){
		$now_timestamp = time();
		$strDateStart = date('Y-m-d H:i:s', $now_timestamp - 1800);
		$strDateEnd   = date('Y-m-d H:i:s', $now_timestamp);
		$verify_record = SmsVerifyRecord::where(array('uid'=>$uid, 'code'=>$code, 'phone_nu'=>$phone_nu, 'type'=>self::TYPE_USER))
			->count();
		return $verify_record;
	}

	/**
	 * 记录日志
	 */
	public static function addRecord($uid, $code, $msg, $phone_nu, $type){
		$objSmsRecord = new SmsVerifyRecord;
		$objSmsRecord->uid = $uid;
		$objSmsRecord->type = $type;
		$objSmsRecord->msg = $msg;
		$objSmsRecord->phone_nu = $phone_nu;
		$objSmsRecord->code = $code;
		$objSmsRecord->ctime = date('Y-m-d H:i:s');
		$res = $objSmsRecord->save();
		if(!$res){
			Log::error("【记录短信发送日志失败】- 用户ID ".$uid." 手机号 ".$phone_nu.",短信内容为:".$msg);
		}
		return $res;
	}

}

