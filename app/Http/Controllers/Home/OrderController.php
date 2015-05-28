<?php 
/**
 * 订单类
 * @author  xuwenzhi 358350782@qq.com
 * @time    2015/5/25 22:00:00
 */
namespace App\Http\Controllers\Home;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Util;
use App\Services\Protocol;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use App\Goods;
use App\School;
use App\GoodsView;
use App\Orders;
use App\GoodsType;
use App\User;

class OrderController extends HomeController {

	/**
	 * 创建订单模板
	 */
	public function precheck($enId){
		//检查用户是否已经验证手机号
		if(!$this->checkUserRole()){			
			return Redirect::to('/verify/buygoods');
		}
		$goods_id = Util::encryptData($enId, true);
		if(!$goods_id){
			return Redirect::to('/goods/surprise/null');
		}
		$goods_info = Goods::where(array('id' => $goods_id))
			-> select('id','title', 'uid', 'status', 'content', 'price', 'deal_type', 'school_id', 'deal_place_ext', 'new_level','ctime') 
			-> get();
		
		if(!$goods_info){
			return Redirect::to('/goods/surprise/null');
		}
		$uid = $this->getLogUid();
		$create_btn_active = true;
		$create_btn_txt = '信息确认无误，创建订单';
		if($goods_info[0]['uid'] == $uid){
			$create_btn_active = false;
			$create_btn_txt = '您不能对自己的商品下单';
		}
		$goods_info = Goods::decorateList($goods_info);
		$goods_info = $goods_info[0];
		//检查货的状态
		if(!Goods::checkGoodsCanDeal($goods_info['status'])){
			//想下单？但是一瞬间买不了，那怎么办？跳转到一个页面，做一些同类货的推荐
			return Redirect::to('/goods/surprise/seckill');
		}
		$goods_info['school_name'] = School::getNameById($goods_info['school_id']);
		$data = array(
			'goods_info' => $goods_info,
			'create_btn_active' => $create_btn_active,
			'create_btn_txt' => $create_btn_txt,
		);
		return view('app.order.precheck', $data);
	}

	/**
	 * create
	 */
	public function create(Request $request){
		if(!$this->checkUserRole()){
			return Redirect::to('/verify/buygoods');
		}
		$goods_id = Util::encryptData($request->get('enId'), true);
		if(!$goods_id){
			return Redirect::to('/goods/surprise/null');
		}
		$uid = $this->getLogUid();
		if(!$uid){
			return Redirect::to('/auth/login');
		}
		//检查该用户是否已经查看过该商品，防止乱提交
		if(!GoodsView::getUserViewsByGoodsid($goods_id, $uid)){
			return Redirect::to('/error');
		}
		$goods_info = Goods::where(array('id' => $goods_id))
			-> select('id','title', 'uid', 'status', 'content', 'type', 'price', 'deal_type', 'school_id', 'deal_place_ext', 'new_level','ctime') 
			-> get();
		if(!$goods_info){
			return Redirect::to('/goods/surprise/null');
		}
		//如果有这个用户和这个商品的订单，那跳到该用户的订单列表
		$arrExistOrder = Orders::checkUserGoodsExist($uid, $goods_id);
		if(!count($arrExistOrder)){
			return Redirect::to('/order/'.Util::encryptData($arrExistOrder[0]['id']).'/detail');
		}
		if(!$goods_info){
			return Redirect::to('/goods/null');
		}
		$goods_info = $goods_info[0];
		//检查货的状态
		if(!Goods::checkGoodsCanDeal($goods_info['status'])){
			//结果被人抢了
			return Redirect::to('/goods/surprise/seckill');
		}
		//执行下单
		$res_insert = $this->_insert($goods_info, $uid);
		if(!$res_insert){
			return Redirect::to('/order/surprise/'.$request->get('enId'));
		}
		//修改商品的状态为不可出售
		if(!Goods::updateGoodsStatus($goods_id , Goods::STATUS_DEALING)){
			Log::error("【更改货物状态失败】货物id:".$goods_id."欲改为".Goods::STATUS_DEALING."用户ID是".$uid."订单ID是".$res_insert);
		}
		return Redirect::to('/order/'.Util::encryptData($res_insert).'/detail');
	}


	private function _insert($goods_info, $uid){
		$objOrder = new Orders;
		$objOrder -> status = Orders::STATUS_DEALING;
		$objOrder -> type = Orders::TYPE_SELL;
		$objOrder -> uid = $uid;
		$objOrder -> ctime = date('Y-m-d H:i:s');
		$objOrder -> goods_id = $goods_info['id'];
		$objOrder -> price = $goods_info['price'];
		$objOrder -> deal_type = $goods_info['deal_type'];
		$objOrder -> school_id = $goods_info['school_id'];
		$objOrder -> deal_place_ext = $goods_info['deal_place_ext'];
		$objOrder -> goods_title = $goods_info['title'];
		$objOrder -> goods_uid = $goods_info['uid'];
		$objOrder -> goods_type = $goods_info['type'];
		$objOrder -> goods_content = $goods_info['content'];
		if(!$objOrder -> save()){
			Log::error("【订单创建失败】".var_export($goods_info, true)."【用户id】 :".$uid);
			return false;
		}
		return $objOrder->id;
	}

	/**
	 * 订单详情页
	 */
	public function detail($enId){
		$id = Util::encryptData($enId, true);
		if(!$id){
			return Redirect::to('/404');
		}
		$arrOrder = Orders::where(array('id'=>$id))->get();
		if(!$arrOrder){
			return Redirect::to('/404');
		}
		$arrOrder = Orders::decorateList($arrOrder);
		$arrOrder = $arrOrder[0];
		$uid = $this->getLogUid();
		if(!$uid){
			return Redirect::to('/auth/login');
		}
		if(!Util::is_in_array($uid, array($arrOrder['uid'], $arrOrder['goods_uid']))){
			return Redirect::to('/error');
		}
		$belong_buyer = $uid == $arrOrder['uid'] ? true : false;
		$recommend_widget_title = '';
		$recommend_widget_body = array();
		if($belong_buyer){
			//获取卖家信息
			$arrUser = User::where(array('id'=>$arrOrder['goods_uid']))->get();
			$recommend_widget_body = Goods::getUserOtherGoods($arrOrder['goods_uid'], $arrOrder['goods_id']);
			$recommend_widget_body = Goods::decorateList($recommend_widget_body);
			$recommend_widget_title = '卖家还在卖';
		} else {
			//获取买家信息
			$arrUser = User::where(array('id'=>$arrOrder['uid']))->get();
			$recommend_widget_body = Orders::getUserOtherOrder($uid, $id, Orders::ORDER_ROLE_SELLER);
			$recommend_widget_title = '我的其他订单';
		}
		$arrUser = isset($arrUser[0]) ? $arrUser[0] :array();
		$arrOrder['school_name'] = School::getNameById($arrOrder['school_id']);
		$arrOrder['goods_type']  =  GoodsType::getNameByCode($arrOrder['goods_type']);
		$arrUser['phone_nu_en'] = Util::mask_phone_nu($arrUser['phone_nu']);
		$data = array(
			'order' 		=> $arrOrder,
			'belong_buyer'  => $belong_buyer,
			'user'			=> $arrUser,
			'recommend_widget_title' => $recommend_widget_title,
			'recommend_widget_body'=>$recommend_widget_body,
		);
		return view('app.order.detail', $data);
	}

	public function mine(){
		$uid = $this->getLogUid();
		if(!$uid){
			return Redirect::to('/404');
		}
		$arrOrders = Orders::where(array('uid'=>$uid))
			-> orWhere('goods_uid', $uid)
			-> orderBy('ctime', 'desc')
			-> get();
		$arrOrders = Orders::encryptCode($arrOrders);
		$data = array(
			'baselist' => $arrOrders,
		);
		return view('app.order.mine', $data);
	}


	public function surprise($type){
		$data = array(
			'show' => '订单创建失败,重试一把 ？',
			'enId' => $type
		);
		return view('app.order.surprise', $data);
	}
}
