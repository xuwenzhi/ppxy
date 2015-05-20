<?php 
namespace App\Http\Controllers\Home;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use Illuminate\Session;
use Illuminate\Support\Facades\Log;
use App\Util;
use Illuminate\Support\Facades\Redirect;

class GoodsController extends HomeController {

	public function myGoodsList(){

	}

	/**
	 * 发布新商品页面
	 */
	public function tplNew() {
		$data = array(
			'types' => array(array('id'=>1, 'name'=>'电子类'), array('id'=>2, 'name'=>'生活类'),),
		);
		return view('app.goods.newgoods', $data);
	}

	public function doNew(Request $request){
		$arrRequest = $request -> all();
		$uid = $this->getLogUid();
		$arrRequest['uid'] = $uid;
		$res = $this->_insert($arrRequest);
		if($res){
			return Redirect::to('/goods/detail/'.Util::encryptData($res));
		}
	}

	private function _insert($arrData){
		$objGoods = new Goods;
		$objGoods->title = $arrData['goods_title'];
		$objGoods->type = $arrData['goods_type'];
		$objGoods->price = $arrData['goods_price'];
		$objGoods->content = $arrData['goods_content'];
		$objGoods->uid = $arrData['uid'];
		$objGoods->special = Goods::SPECIAL_NORMAL;
		$objGoods->status  = Goods::STATUS_SELL;
		$objGoods->deal_type = Goods::DEAL_TYPE_FACETOFACE;
		$objGoods->destination = Goods::DESTINATION_SELL;
		$objGoods->extra_welfare = '';
		$res = $objGoods->save();
		if(!$res){
			Log::error('【添加商品报错】', ['context' => $arrData]);
			return array();
		}
		return $objGoods -> id;
	}


	public function detail($enId){
		$id = Util::encryptData($enId, true);
		echo $id;
		$data = array(
			
		);		
		return view('app.goods.detail', $data);
	}
}
