<?php 
/**
 * 主页
 */
namespace App\Http\Controllers\Home;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\School;
use App\Util;
use App\GoodsPhoto;
use App\Services\Protocol;

class IndexController extends HomeController {

	protected $boolNeedLogin = false;

	public function index() {
		$arrGoods = Goods::IndexSingleList();
		$arrGoodsIds = Util::column($arrGoods, 'id');
		$arrGoods = Util::batch_substr_utf8($arrGoods, 'content', 50);
		//获取图片
		$arrGoodsPhoto = GoodsPhoto::getCoverPhotoByGoodsIds($arrGoodsIds);
		$arrGoodsPhoto = Util::setKey($arrGoodsPhoto, 'goods_id');
		foreach($arrGoods as $goods){
			$goods['img_thumb_path'] = isset($arrGoodsPhoto[$goods['id']]) && !isset($goods['img_thumb_path']) ? $arrGoodsPhoto[$goods['id']]['thumb'] : '';
		}
		$arrGoods = Goods::decorateList($arrGoods);
		$data = array(
			'goods'=>$arrGoods,
		);
		return view('app.index', $data);
	}

	public function complexList(){
		$arrGoods = Goods::IndexComplexList();
		$arrGoodsIds = Util::column($arrGoods, 'id');
		$arrGoods = Util::batch_substr_utf8($arrGoods, 'content', 50);
		//获取图片
		$arrGoodsPhoto = GoodsPhoto::getCoverPhotoByGoodsIds($arrGoodsIds);
		$arrGoodsPhoto = Util::setKey($arrGoodsPhoto, 'goods_id');
		foreach($arrGoods as $goods){
			$goods['img_thumb_path'] = isset($arrGoodsPhoto[$goods['id']]) && !isset($goods['img_thumb_path']) ? $arrGoodsPhoto[$goods['id']]['thumb'] : '';
		}
		$arrGoods = Goods::decorateList($arrGoods);
		$data = array(
			'goods'=>$arrGoods,
		);
		return view('app.complex', $data);
	}

	public function big4List(){
		$arrGoods = Goods::IndexBig4List();
		$arrGoodsIds = Util::column($arrGoods, 'id');
		$arrGoods = Util::batch_substr_utf8($arrGoods, 'content', 50);
		//获取图片
		$arrGoodsPhoto = GoodsPhoto::getCoverPhotoByGoodsIds($arrGoodsIds);
		$arrGoodsPhoto = Util::setKey($arrGoodsPhoto, 'goods_id');
		foreach($arrGoods as $goods){
			$goods['img_thumb_path'] = isset($arrGoodsPhoto[$goods['id']]) && !isset($goods['img_thumb_path']) ? $arrGoodsPhoto[$goods['id']]['thumb'] : '';
		}
		$arrGoods = Goods::decorateList($arrGoods);
		$data = array(
			'goods'=>$arrGoods,
		);
		return view('app.big4', $data);
	}

}
