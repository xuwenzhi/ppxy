<?php namespace App;

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

}
