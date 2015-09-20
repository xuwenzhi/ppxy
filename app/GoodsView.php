<?php namespace App;

class GoodsView extends Base {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'goods_view';

	public $timestamps = false;

	/**
	 * 记录商品和用户的浏览
	 */
	public static function addVies($intGoodsId, $uid){
		$objGoodsView = new GoodsView;
		$objGoodsView -> goods_id = $intGoodsId;
		$objGoodsView -> uid = $uid;
		$objGoodsView -> ctime = date('Y-m-d H:i:s');
		return $objGoodsView -> save();
	}

	/**
	 * 获取某商品被查看的次数
	 */
	public static function getUserViewsByGoods($id){
		$intViewTimes = GoodsView::where(array('goods_id'=>$id))-> distinct()->select('goods_id', 'uid')->count();
		return $intViewTimes;
	}

	/**
	 * 获得用户查看某件商品的次数
	 */
	public static function getUserViewsByGoodsid($goods_id, $uid){
		if(!$goods_id || !$uid ){
			return array();
		}
		$count = GoodsView::where(array('uid' => $uid, 'goods_id' => $goods_id))
			->count();
		return $count;
	}

}

