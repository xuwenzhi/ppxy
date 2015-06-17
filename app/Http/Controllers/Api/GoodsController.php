<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\GoodsType;
class GoodsController extends ApiController {

	/**
	 * 获取商品大类列表
	 */
	public function getBigType(Request $request){
		$goods_types = GoodsType::getFirstType();
		$goods_types = GoodsType::encryptCode($goods_types);
		$this->send(0, '', $goods_types);
	}

}
