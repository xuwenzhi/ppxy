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
	const STATUS_NEWBIE  = "newbie";
	const STATUS_SELL    = "sell";
	const STATUS_RENT    = "rent";
	const STATUS_HIDE    = "hide";
	const STATUS_CLOSE   = "close";
	const STATUS_DEAL    = "已卖出";
	const STATUS_DEALING = "dealing";

	public static $arrStatus = array(
		self::STATUS_NEWBIE  => '待审核',
		self::STATUS_SELL    => '正在出售',
		self::STATUS_RENT    => '正在出租',
		self::STATUS_HIDE    => '不出售',
		self::STATUS_CLOSE   => '已退出平台',
		self::STATUS_DEAL    => '已成交',
		self::STATUS_DEALING => '正在交易',
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

	//几成新
	public static $arrNewLevel = array(
		'ten'  => '全新',
		'nine'  => '九成新',
		'eight' => '八成新',
		'seven' => '七成新',
		'six'   => '六成新',
		'five'  => '五成新',
		'four'  => '四成新',
		'three' => '三成新',
		'two'   => '二成新',
		'one'   => '一成新',
	);

	/**
	 * 数据加工
	 */
	public static function decorateList($arrGoods){
		if(!$arrGoods){
			return array();
		}
		$arrSpecial     = self::$arrSpecial;
		$arrStatus      = self::$arrStatus;
		$arrDealType    = self::$arrDealType;
		$arrDestination = self::$arrDestination;
		$arrUid  = Util::column($arrGoods, 'uid');
		$arrUser = User::whereIn('id', $arrUid)->select('id', 'name')->get();
		$arrUser = Util::setKey($arrUser, 'id');
		$arrSchoolId = Util::column($arrGoods, 'school_id');
		$arrSchool = School::whereIn('id', $arrSchoolId)->select('id', 'name')->get();
		$arrSchool = Util::setKey($arrSchool, 'id');
		$arrGoodsTypeCode = Util::column($arrGoods, 'type');
		$arrGoodsTypes = GoodsType::whereIn('code', $arrGoodsTypeCode) -> get();		
		$arrGoodsTypes = Util::setKey($arrGoodsTypes,'code');
		foreach($arrGoods as $goods){
			$goods['id']              = Util::encryptData($goods['id']);
			$goods['username']        = isset($arrUser[$goods['uid']]['name']) ? $arrUser[$goods['uid']]['name'] : '';
			$goods['special_txt']     = isset($arrSpecial[$goods['special']]) ? $arrSpecial[$goods['special']] : '';
			$goods['status_txt']      = isset($arrStatus[$goods['status']]) ? $arrStatus[$goods['status']] : '';
			$goods['dealtype_txt']    = isset($arrDealType[$goods['deal_type']]) ? $arrDealType[$goods['deal_type']] : '';
			$goods['destination_txt'] = isset($arrDestination[$goods['destination']]) ? $arrDestination[$goods['destination']] : '';
			$goods['uid']             = Util::encryptData($goods['uid']);
			$goods['trans_time']      = Util::timeTrans($goods['ctime']);
			$goods['school_name']     = isset($arrSchool[$goods['school_id']]) ? $arrSchool[$goods['school_id']]['name'] : '';
			$goods['type_name']     = isset($arrGoodsTypes[$goods['type']]) ? $arrGoodsTypes[$goods['type']]['name'] : '';
		}
		return $arrGoods;
	}

	/**
	 * 检查该商品是否可以出售
	 * @param  string $status 商品状态
	 */
	public static function checkGoodsCanDeal($status){
		if($status == self::STATUS_SELL){
			return true;
		}
	}

	public static function updateGoodsStatus($goods_id, $new_status){
		if(!$goods_id || !$new_status){
			return array();
		}
		$objGoods = Goods::find($goods_id);
		$objGoods->status = $new_status;
		return $objGoods->save();
	}

	/**
	 * 获取同类产品
	 */
	public static function getSameTypeGoods($type_code, $crt_goods_id, $uid = null){
		if($type_code == ''){
			return array();
		}
		if(!$uid){
			$uid = array();
		}
		$same_goods = Goods::where(array('type'=>$type_code))
			->whereNotIn('uid', $uid)
			->whereNotIn('id', array($crt_goods_id))
			->where(array('status'=>self::STATUS_SELL))
			->select('id', 'title', 'price', 'uid', 'ctime')
			->orderBy('ctime', 'desc')
			->paginate(6);
		return $same_goods;
	}

	public static function getUserAllGoods($uid, $page = 1, $pagesize = 20){
		if(!$uid){
			return array();
		}
		$skip = ($page-1) * $pagesize;
		$arrRes = Goods::where(array('uid' => $uid ))
				->orderBy('ctime', 'desc')
				->skip($skip)
				->take($pagesize)
				->get();
		return $arrRes;
	}

	/**
	 * 获取某用户的其他产品
	 */
	public static function getUserOtherGoods($uid, $crt_goods_id = 0){
		if(!$uid){
			return array();
		}
		$arrRes = Goods::where(array('uid' => $uid ))
				-> where('id', '!=', $crt_goods_id)
				-> where(array('status'=>self::STATUS_SELL))
				-> orderBy('ctime', 'desc')
				-> paginate(6);
		return $arrRes;
	}


	/**
	 * 获取主页单品列表
	 */
	public static function IndexSingleList($page = 1, $pagesize = 20){
		$skip = ($page-1) * $pagesize;
		return Goods::where(array('status' => self::STATUS_SELL))
			->whereNotIn('type', array_merge(GoodsType::$arrComplex, GoodsType::$arrBig4))
			->select('id', 'title', 'price', 'uid', 'ctime', 'view_times','uid', 'content', 'ctime', 'school_id', 'deal_place_ext', 'type')
			->orderBy('ctime', 'desc')
			->skip($skip)
			->take($pagesize)
			->get();
	}

	/**
	 * 获取大杂烩主页列表
	 */
	public static function IndexComplexList($page = 1, $pagesize = 20){
		$skip = ($page-1) * $pagesize;
		return Goods::where(array('status' => self::STATUS_SELL))
			->whereIn('type', GoodsType::$arrComplex)
			->select('id', 'title', 'price', 'uid', 'ctime', 'view_times','uid', 'content', 'ctime', 'school_id', 'deal_place_ext', 'type')
			->orderBy('ctime', 'desc')
			->skip($skip)
			->take($pagesize)
			->get();
	}

	/**
	 * 获取大四专区商品
	 * @param integer $page     [description]
	 * @param integer $pagesize [description]
	 */
	public static function IndexBig4List($page = 1, $pagesize = 20){
		$skip = ($page-1) * $pagesize;
		return Goods::where(array('status' => self::STATUS_SELL))
			->whereIn('type', GoodsType::$arrBig4)
			->select('id', 'title', 'price', 'uid', 'ctime', 'view_times','uid', 'content', 'ctime', 'school_id', 'deal_place_ext', 'type')
			->orderBy('ctime', 'desc')
			->skip($skip)
			->take($pagesize)
			->get();
	}

	/**
	 * 加载更多
	 * @param  [type]  $type     [description]
	 * @param  [type]  $page     [description]
	 * @param  integer $pagesize [description]
	 * @return [type]            [description]
	 */
	public static function load_more($type, $page, $pagesize = 20){
		if($type == GoodsType::BIG_TYPE_SINGLE){
			return self::IndexSingleList($page, $pagesize);
		}else if($type == GoodsType::BIG_TYPE_COMPLEX){
			return self::IndexComplexList($page, $pagesize);
		}else if($type == GoodsType::BIG_TYPE_BIG4){
			return self::IndexBig4List($page, $pagesize);
		}else{
			return array();
		}
	}

}
