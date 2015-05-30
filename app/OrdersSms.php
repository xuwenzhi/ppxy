<?php 
/**
 * 订单短信通知类
 * @author 徐文志 358350782@qq.com
 * @time   2015/5/26 14:21:00
 */
namespace App;
use App\Orders;
use App\User;
use App\Services\Sms;
use Illuminate\Support\Facades\Log;
use App\SmsVerifyRecord;
class OrdersSms{

	const ORDER_DETAIL_URL = "/order/%s/detail";

	const CREATE_SEND_SELLER = "%s先生/女士，[%s]要购买您的[%s]，TA的手机号为 : %s 。请注意: 您的[%s]当前为不可出售状态，若与买家线下验货失败，您需要手动操作为出售状态，谢谢合作。详细信息查看: %s ";
	const CREATE_SEND_BUYER  = "%s先生/女士，恭喜您对[%s]成功下单，卖家的手机号为 : %s ，您可以点击联系卖家。详细信息查看: %s";

	/**
	 * 订单创建成功发送短信
	 */
	public static function createOrder($oid){
		$order_info = Orders::where(array('id'=>$oid))
			->select('id','uid', 'title', 'deal_type', 'school_id', 'deal_place_ext', 'goods_uid')
			->get();
		if($order_info){
			$order_info = $order_info[0];
			$arrUser = User::batchGetUser(array($order_info['uid'], $order_info['goods_uid']));
			$arrUser = Util::setKey($arrUser);
			self::createSendSeller($order_info, $arrUser);
			self::createSendBuyer($order_info, $arrUser);
		}
	}

	//创建成功给卖家发短信
	public static function createSendSeller($order_info, $arrUser){
		$url = sprintf(env('DOMAIN_NAME').self::ORDER_DETAIL_URL, Util::encryptData($order_info['id']));
		$decorateUrl = sprintf("<a href='%s'>%s</a>", $url, '点此进入');
		$msg = sprintf(self::CREATE_SEND_SELLER, 
				$arrUser[$order_info['goods_uid']]['name'],
				$arrUser[$order_info['uid']]['name'],
				$order_info['title'],
				$arrUser[$order_info['uid']]['phone_nu'],
				$order_info['title'],
				$decorateUrl
			);
		$hp = $arrUser[$order_info['goods_uid']]['phone_nu'];
		$objSms = new Sms;
		if(!($objSms->setHp($hp) -> setMsg($msg) -> sendSingle())){
			Log::error("【短信发送失败】【创建订单通知卖家失败】手机号:".$hp."短信内容:".$msg);
		}else{
			SmsVerifyRecord::addRecord($order_info['goods_uid'], '', $msg, $hp, SmsVerifyRecord::TYPE_ORDER);
		}
		return;
	}

	//创建成功给买家
	public static function createSendBuyer($order_info, $arrUser){
		$url = sprintf(env('DOMAIN_NAME').self::ORDER_DETAIL_URL, Util::encryptData($order_info['id']));
		$decorateUrl = sprintf("<a href='%s'>%s</a>", $url, '点此进入');
		$msg = sprintf(self::CREATE_SEND_BUYER, 
				$arrUser[$order_info['uid']]['name'],
				$order_info['title'],
				$arrUser[$order_info['goods_uid']]['phone_nu'],
				$decorateUrl
			);
		$hp = $arrUser[$order_info['uid']]['phone_nu'];
		$objSms = new Sms;
		if(!($objSms->setHp($hp) -> setMsg($msg) -> sendSingle())){
			Log::error("【短信发送失败】【创建订单通知买家失败】手机号:".$hp."短信内容:".$msg);
		}else{
			SmsVerifyRecord::addRecord($order_info['uid'], '', $msg, $hp, SmsVerifyRecord::TYPE_ORDER);
		}
		return;
	}
}
