<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Goods;
use App\Util;
use App\User;
class GoodsController extends AdminController {

	/**
	 * 全部商品列表
	 */
	public function all() {
		$arrGoods = Goods::paginate($this->intPageSize);
		$arrGoods = $this->_decorateList($arrGoods);
		$data = array(
        	'goods' => $arrGoods,
        	'title' => '所有商品',
	    );
	    return view('admin.goods.goodslist', $data);
	}

	

	private function _decorateList($arrGoods){
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
			$goods['username'] = isset($arrUser[$goods['uid']]['name']) ? $arrUser[$goods['uid']]['name'] : '';
			$goods['special_txt'] = isset($arrSpecial[$goods['special']]) ? $arrSpecial[$goods['special']] : '';
			$goods['status_txt'] = isset($arrStatus[$goods['status']]) ? $arrStatus[$goods['status']] : '';
			$goods['dealtype_txt'] = isset($arrDealType[$goods['deal_type']]) ? $arrDealType[$goods['deal_type']] : '';
			$goods['destination_txt'] = isset($arrDestination[$goods['destination']]) ? $arrDestination[$goods['destination']] : '';
		}
		return $arrGoods;
	}

}
