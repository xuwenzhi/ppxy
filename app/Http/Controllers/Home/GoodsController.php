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
use App\GoodsPhoto;

class GoodsController extends HomeController {

	protected $boolNeedLogin = false;

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
		$lastId = $this->_insert($arrRequest);
		if($lastId){
			return Redirect::to('/goods/detail/'.Util::encryptData($lastId));
		} else {
			echo '很抱歉，添加失败!请重试';
		}
	}

	/**
	 * 添加一条数据
	 */
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
		$id = intval(Util::encryptData($enId, true));
		if(!$id){
			return Redirect::to('/404');
		}

		$arrGoods = Goods::where(array('id' => $id)) -> get();
		$arrGoods = Goods::decorateList($arrGoods);
		$arrPhoto = GoodsPhoto::whereIn('goods_id', array($id))->get();
		$arrGoods = $arrGoods[0];
		$strFooterTxt = "立即购买";
		$data = array(
			'goods' => $arrGoods,
			'title' => $arrGoods['title'],
			'photos' => $arrPhoto,
			'special_recommend' => Goods::SPECIAL_RECOMMEND,
			'footer_show_txt' => $strFooterTxt,
		);
		$this->_addViews($id, $arrGoods['view_times']);
		return view('app.goods.detail', $data);
	}

	private function _addViews($id, $view_times){
		if(!$id){
			return;
		}
		$objGoods = Goods::find($id);
		$objGoods -> view_times = $view_times+1;
		return $objGoods->save();
	}
}
