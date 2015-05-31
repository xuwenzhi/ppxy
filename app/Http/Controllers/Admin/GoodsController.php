<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\Util;
use App\User;
use App\GoodsPhoto;
use Illuminate\Support\Facades\Redirect;


class GoodsController extends AdminController {

	public function __construct(){
		if($this->strAdminRole != 'admin'){
			return Redirect::to('/error');
		}
	}
	/**
	 * 全部商品列表
	 */
	public function all() {
		if($this->strAdminRole != 'admin'){
			return Redirect::to('/error');
		}
		$arrGoods = Goods::paginate($this->intPageSize);
		$arrGoods = $this->_decorateList($arrGoods);
		$data = array(
        	'goods' => $arrGoods,
        	'title' => '所有商品',
	    );
	    return view('admin.goods.goodslist', $data);
	}

	/**
	 * 商品详情页
	 */
	public function detail($enId){
		if($this->strAdminRole != 'admin'){
			return Redirect::to('/error');
		}
		$id = Util::encryptData($enId, true);
		echo $id;
		exit;
		if(!$id){
			return Redirect::to('/404');
		}
		$arrGoods = Goods::where(array('id' => $id)) -> get();
		$arrGoods = $this->_decorateList($arrGoods);
		$arrPhoto = GoodsPhoto::whereIn('goods_id', array($id))->get();
		$data = array(
			'goods' => $arrGoods,
			'title' => $arrGoods[0]['title'],
			'photos' => $arrPhoto,
		);
		return view('admin.goods.goodsdetail', $data);
	}

	/**
	 * 数据加工
	 */
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
			$goods['id']              = Util::encryptData($goods['id']);
			$goods['username']        = isset($arrUser[$goods['uid']]['name']) ? $arrUser[$goods['uid']]['name'] : '';
			$goods['special_txt']     = isset($arrSpecial[$goods['special']]) ? $arrSpecial[$goods['special']] : '';
			$goods['status_txt']      = isset($arrStatus[$goods['status']]) ? $arrStatus[$goods['status']] : '';
			$goods['dealtype_txt']    = isset($arrDealType[$goods['deal_type']]) ? $arrDealType[$goods['deal_type']] : '';
			$goods['destination_txt'] = isset($arrDestination[$goods['destination']]) ? $arrDestination[$goods['destination']] : '';
			$goods['uid']             = Util::encryptData($goods['uid']);
		}
		return $arrGoods;
	}

}
