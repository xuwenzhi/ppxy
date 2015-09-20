<?php 
/**
 * 订单
 * @author 徐文志 358350782@qq.com
 * @time   2015/5/26 13:40:00
 */
namespace App;
class Orders extends Base {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table     = 'orders';
	public $timestamps   = false;
	
	//订单状态
	const STATUS_PENDING = 'pending';
	const STATUS_CANCEL  = 'cancel';
	const STATUS_ACCEPT  = 'accept';
	const STATUS_REJECT  = 'rejected';
	const STATUS_DEALING = 'dealing';
	const STATUS_DEALED  = 'dealed';
	const STATUS_FAILED  = 'failed';

	public static $arrStatus = array(
		self::STATUS_DEALING => '线下交易中',
		self::STATUS_DEALED  => '交易完成',
		self::STATUS_FAILED  => '交易失败',
	);

	//扩展状态
	const STATUS_EXT_BEFORE_ACCEPT  = 10;  //卖家接受前取消
	const STATUS_EXT_AFTER_ACCEPT   = 20;  //卖家接受后取消
	const STATUS_EXT_STRIGHT_REJECT = 30;  //卖家直接拒绝
	const STATUS_EXT_REJECT_AFT_APT = 40;  //卖家接收后拒绝

	const TYPE_SELL = 'sell';
	const TYPE_RENT = 'rent';
	public static $arrType = array(
		self::TYPE_SELL => '出售',
		self::TYPE_RENT => '出租',
	);

	//卖家和买家
	const ORDER_ROLE_BUYER  = 'buyer';
	const ORDER_ROLE_SELLER = 'seller';

	/**
	 * 检查同一个用户是否对同一个货下单
	 */
	public static function checkUserGoodsExist($uid, $goods_id){
		$strDateStart = date('Y-m-d 00:00:00');
		$strDateEnd   = date('Y-m-d 23:59:59');
		$arrRes = Orders::where(array('uid'=>$uid, 'goods_id'=>$goods_id))
			->whereBetween('ctime', array($strDateStart, $strDateEnd))
			->get();
		return $arrRes;
	}

	public static function decorateList($arrOrder){
		if(!$arrOrder){
			return array();
		}
		$arrStatus = self::$arrStatus;
		foreach($arrOrder as $val){
			$val['status_txt'] = $arrStatus[$val['status']];
		}
		return $arrOrder;
	}

	/**
	 * 获取用户的其他订单
	 * 包括区分了 用户是 买家还是卖家
	 */
	public static function getUserOtherOrder($uid, $crt_order_id, $type = 'buyer'){
		if(!$uid){
			return array();
		}
		if($type == self::ORDER_ROLE_BUYER){
			$arrRes = Orders::where(array('uid' => $uid ))
				-> where('id', '!=', $crt_order_id)
				-> get();
			return $arrRes;
		}else{
			$arrRes = Orders::where(array('goods_uid' => $uid ))
				-> where('id', '!=', $crt_order_id)
				-> get();
			return $arrRes;
		}
	}

	public static function encryptCode($arrData){
		if(!$arrData){
			return array();
		}
		foreach($arrData as $val){
			$val['id'] = Util::encryptData($val['id']);
		}
		return $arrData;
	}

}
