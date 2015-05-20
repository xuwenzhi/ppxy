<?php namespace App;
use App\Util;
class Goods extends Base {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'goods';

	public $timestamps = false;

	//商品类型
	const SPECIAL_NORMAL    = 'normal';
	const SPECIAL_RECOMMEND = 'recommend';

	public static $arrSpecial = array(
		self::SPECIAL_NORMAL    => '否',
		self::SPECIAL_RECOMMEND => '是',
	);

	//商品状态
	const STATUS_NEWBIE = "newbie";
	const STATUS_SELL   = "sell";
	const STATUS_RENT   = "rent";
	const STATUS_HIDE   = "hide";
	const STATUS_CLOSE  = "close";
	const STATUS_DEAL   = "deal";

	public static $arrStatus = array(
		self::STATUS_NEWBIE => '待审核',
		self::STATUS_SELL   => '正在出售',
		self::STATUS_RENT   => '正在出租',
		self::STATUS_HIDE   => '已隐藏',
		self::STATUS_CLOSE  => '已退出平台',
		self::STATUS_DEAL   => '已成交',
	);

	//交易方式
	const DEAL_TYPE_FACETOFACE = 'facetoface';
	const DEAL_TYPE_ONLINE     = 'online';
	const DEAL_TYPE_ALL        = 'all';

	public static $arrDealType = array(
		self::DEAL_TYPE_FACETOFACE => '当面交易',
		self::DEAL_TYPE_ONLINE     => '在线交易',
		self::DEAL_TYPE_ALL        => '不限',
	);

	//上架目的
	const DESTINATION_SELL  = 'sell';
	const DESTINATION_SHARE = 'share';

	public static $arrDestination = array(
		self::DESTINATION_SELL => '出售',
		self::DESTINATION_SELL => '出租',
	);

	/**
	 * 数据加工
	 */
	public static function decorateList($arrGoods){
		if(!$arrGoods){
			return array();
		}
		$arrSpecial     = Goods::$arrSpecial;
		$arrStatus      = Goods::$arrStatus;
		$arrDealType    = Goods::$arrDealType;
		$arrDestination = Goods::$arrDestination;

		$arrUid  = Util::column($arrGoods, 'uid');
		$arrUser = User::whereIn('id', $arrUid)->select('id', 'name')->get();
		$arrUser = Util::setKey($arrUser, 'id');
		foreach($arrGoods as $goods){
			$goods['id']              = Util::encryptData($goods['id']);
			$goods['username']        = isset($arrUser[$goods['uid']]['name']) ? $arrUser[$goods['uid']]['name'] : '';
			$goods['special_txt']     = isset($arrSpecial[$goods['special']]) ? $arrSpecial[$goods['special']] : '';
			$goods['status_txt']      = isset($arrStatus[$goods['status']]) ? $arrStatus[$goods['status']] : '';
			$goods['dealtype_txt']    = isset($arrDealType[$goods['deal_type']]) ? $arrDealType[$goods['deal_type']] : '';
			$goods['destination_txt'] = isset($arrDestination[$goods['destination']]) ? $arrDestination[$goods['destination']] : '';
			$goods['uid']             = Util::encryptData($goods['uid']);
			$goods['trans_time']      = Util::timeTrans($goods['ctime']);
		}
		return $arrGoods;
	}

}
