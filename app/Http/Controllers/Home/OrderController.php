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
use App\Goods;
class OrderController extends HomeController {

	/**
	 * 创建订单模板
	 */
	public function tplNew($enId){
		$goods_id = Util::encryptData($enId, true);
		if(!$goods_id){
			return Redirect::to('/goods/null');
		}
		$goods_info = Goods::where(array('id' => $goods_id))
			-> select('title', 'uid', 'status', 'content', 'price', 'deal_type', 'school_id', 'deal_place_ext') 
			-> get();
		if(!$goods_info){
			return Redirect::to('/goods/null');
		}
		$goods_info = $goods_info[0];
		//检查货的状态
		if(!Goods::checkGoodsCanDeal($goods_info['status'])){
			//想下单？但是一瞬间买不了，那怎么办？跳转到一个页面，做一些同类货的推荐
			return Redirect::to('/goods/surprise');
		}
		$data = array(
			
		);
		return view('app.order.new', $data);
	}
}
