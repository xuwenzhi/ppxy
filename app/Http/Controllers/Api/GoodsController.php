<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GoodsType;
use App\Util;
use App\Goods;
use App\User;
class GoodsController extends ApiController {

	/**
	 * 获取商品大类列表
	 */
	public function getBigType(Request $request){
		$goods_types = GoodsType::getFirstType();
		$goods_types = GoodsType::encryptCode($goods_types);
		if($goods_types){
			return $this->send(0, '', $goods_types);
		}
		return $this->send(1);
	}

	/**
	 * 获取商品小类列表
	 */
	public function getSmallType(Request $request){
		$bigtype = $request->get('bigtype');
		if(!$bigtype || $bigtype == ''){
			return $this->send(11);
		}
		$bigtype = Util::encryptData($bigtype, true);
		$second_types = GoodsType::getSecondTypeByFirst($bigtype);
		$second_types = GoodsType::encryptCode($second_types);
		if($second_types){
			return $this->send(0, '', $second_types);
		}
		return $this->send(1);
	}

	/**
	 * 获取商品列表
	 */
	public function getList(Request $request){
		$page = $request->get('page') ? $request->get('page') : 1;
		$pagesize = $request->get('pagesize') ? $request->get('pagesize') : 15;
		$bigtype = $request->get('bigtype');
		$smalltype = $request->get('smalltype');
		$bigtype = $request->get('bigtype') ? Util::encryptData($bigtype, true) : null;
		$smalltype = $request->get('smalltype') ? Util::encryptData($smalltype, true) : null;
		$arrGoods = Goods::search($page, $pagesize, $bigtype, $smalltype);
		if($arrGoods){
			$arrGoods['list'] = Goods::decorateList($arrGoods['list']);
			return $this->send(0, '', $arrGoods);
		}
		return $this->send(2);
	}

	/**
	 * 我的商品列表
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function getMyList(Request $request){
		$page = $request->get('page') ? $request->get('page') : 1;
		$pagesize = $request->get('pagesize') ? $request->get('pagesize') : 15;
		$client = $request->get('user_id');
		if(!$client || $client == ''){
			return $this->send(12);
		}
		if(!$client){
			return $this->send(12);
		}
		$user = User::getUserByClient($client);
		if($user){
			$arrGoods = Goods::getUserAllGoods($user[0]['id'], $page, $pagesize);
			if($arrGoods){
				$arrGoods['list'] = Goods::decorateList($arrGoods['list']);
				return $this->send(0, '', $arrGoods);
			}
			return $this->send(13);
		}
		return $this->send(1);
	}

	public function detail(Request $request){
		$enId = $request->get('enId');
		if(!$enId){
			return $this->send(14);
		}
		$id = Util::encryptData($enId, true);
		$arrGoods = Goods::where(array('id' => $id)) -> get();
		
	}
}
