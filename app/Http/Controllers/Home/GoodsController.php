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
use App\GoodsView;
use App\School;
use App\GoodsType;

class GoodsController extends HomeController {

	protected $boolNeedLogin = false;

	public function myGoodsList(){

	}

	/**
	 * 发布新商品页面
	 */
	public function tplNew() {
		$goods_types = GoodsType::getFirstType();
		$second_types = array();
		if($goods_types){
			$second_types = GoodsType::getSecondTypeByFirst($goods_types[0]['code']);
		}
		$goods_types = GoodsType::encryptCode($goods_types);
		$second_types = GoodsType::encryptCode($second_types);
		$data = array(
			'new_level' => Goods::$arrNewLevel,
			'types' => $goods_types,
			'second_types'=>$second_types,
		);
		return view('app.goods.newgoods', $data);
	}

	public function doNew(Request $request){
		$arrRequest = $request -> all();
		//数据检查
		if(!$this->checkPostGoods($arrRequest)){
			return Redirect::to('/404');
		}
		$uid = $this->getLogUid();
		$arrRequest['uid'] = $uid;
		$arrRequest['goods_type'] = Util::encryptData($arrRequest['goods_type'], true);
		$lastId = $this->_insert($arrRequest);
		if($lastId){
			return Redirect::to('/goods/detail/'.Util::encryptData($lastId));
		} else {
			echo '很抱歉，添加失败!请重试';
		}
	}

	/**
	 * post 商品数据检查
	 */
	private function checkPostGoods($arrData){
		if(isset($arrData['goods_title']) && $arrData['goods_title'] == ''){
			return false;
		}
		if(isset($arrData['goods_price']) && !Util::reg_price($arrData['goods_price'])){
			return false;
		}
		if(isset($arrData['goods_type']) && $arrData['goods_type'] == ''){
			return false;
		}
		return true;
	}

	/**
	 * 添加一条数据
	 */
	private function _insert($arrData){
		$objGoods = new Goods;
		$objGoods->title = $arrData['goods_title'];
		$objGoods->type = $arrData['goods_type'];
		$objGoods->price = $arrData['goods_price'];
		$objGoods->content = trim($arrData['goods_content']);
		$objGoods->uid = $arrData['uid'];
		$objGoods->special = Goods::SPECIAL_NORMAL;
		$objGoods->status  = Goods::STATUS_SELL;
		$objGoods->deal_type = Goods::DEAL_TYPE_FACETOFACE;
		$objGoods->destination = Goods::DESTINATION_SELL;
		$objGoods->new_level = $arrData['goods_newlevel'];
		$objGoods->extra_welfare = '';
		$objGoods->school_id = 480;//学校ID
		$objGoods->deal_place_ext = $arrData['goods_dealplace_ext'];
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
		$uid = $this->getLogUid();
		$boolBelongUser = false;
		if($uid) {
			//增加浏览记录
			GoodsView::addVies($id, $uid);
			//是否是当前登录用户的商品
			$boolBelongUser = $uid == $arrGoods[0]['uid'] ? true : false;
		}
		$arrGoods = Goods::decorateList($arrGoods);
		$arrPhoto = GoodsPhoto::whereIn('goods_id', array($id))->get();
		$arrGoods = $arrGoods[0];
		$arrGoods['school_name'] = School::getNameById($arrGoods['school_id']);
		$strFooterTxt = "立即下单";
		$arrGoods['type'] = GoodsType::getNameByCode($arrGoods['type']);
		$data = array(
			'goods' => $arrGoods,
			'title' => $arrGoods['title'],
			'photos' => $arrPhoto,
			'photo_count' => count($arrPhoto),
			'special_recommend' => Goods::SPECIAL_RECOMMEND,
			'footer_show_txt' => $strFooterTxt,
			'view_times' => GoodsView::getUserViewsByGoods($id),
			'belong_crt_user' => $boolBelongUser,
			'isMobile' => Util::isMobile(),
		);
		return view('app.goods.detail', $data);
	}

	/**
	 * 发现
	 */
	public function find(){
		$data = array(
			
		);
		return view('app.goods.find', $data);
	}

	/**
	 * 我的商品
	 */
	public function mine(){
		$data = array(

		);
		return view('app.goods.mine', $data);
	}

	/**
	 * 修改商品信息
	 */
	public function modify($enId){
		$id = intval(Util::encryptData($enId, true));
		if(!$id){
			Redirect::to('/404');
		}
		$arrGoods = Goods::where(array('id' => $id)) -> get();
		var_dump($arrGoods);
		$data = array(

		);
		return view('app.goods.modify', $data);
	}

	/**
	 * 根据商品大类获取子类
	 */
	public function getsubtype(Request $request){
		$first_type = $request->get('first_type_code');
		$second_types = GoodsType::getSecondTypeByFirst(Util::encryptData($first_type, true));
		if(!$second_types){
			return Util::json_format('error', '数据加载失败,请重试');
		}
		$second_types = GoodsType::encryptCode($second_types);
		return Util::json_format('success', '', $second_types);
	}

}
