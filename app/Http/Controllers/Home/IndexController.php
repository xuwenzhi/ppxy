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
use App\GoodsType;

class IndexController extends HomeController {

	protected $boolNeedLogin = false;

	public function index() {
		$page = 1;
		$pagesize = $this->_generate_pagesize();
		$arrGoods = Goods::IndexSingleList($page, $pagesize);
		$arrGoodsIds = Util::column($arrGoods, 'id');
		//获取图片
		$arrGoodsPhoto = GoodsPhoto::getCoverPhotoByGoodsIds($arrGoodsIds);
		$arrGoodsPhoto = Util::setKey($arrGoodsPhoto, 'goods_id');
		foreach($arrGoods as $goods){
			$goods['img_thumb_path'] = isset($arrGoodsPhoto[$goods['id']]) && !isset($goods['img_thumb_path']) ? $arrGoodsPhoto[$goods['id']]['thumb'] : '';
		}
		$arrGoods = Goods::decorateList($arrGoods);
		$data = array(
			'goods'=>$arrGoods,
			'type' =>GoodsType::BIG_TYPE_SINGLE,
			'active'=>'index',
		);
		return view('app.index', $data);
	}

	public function complexList(){
		$page = 1;
		$pagesize = $this->_generate_pagesize();
		$arrGoods = Goods::IndexComplexList($page, $pagesize);
		$arrGoodsIds = Util::column($arrGoods, 'id');
		//获取图片
		$arrGoodsPhoto = GoodsPhoto::getCoverPhotoByGoodsIds($arrGoodsIds);
		$arrGoodsPhoto = Util::setKey($arrGoodsPhoto, 'goods_id');
		foreach($arrGoods as $goods){
			$goods['img_thumb_path'] = isset($arrGoodsPhoto[$goods['id']]) && !isset($goods['img_thumb_path']) ? $arrGoodsPhoto[$goods['id']]['thumb'] : '';
		}
		$arrGoods = Goods::decorateList($arrGoods);
		$data = array(
			'goods'=>$arrGoods,
			'type' =>GoodsType::BIG_TYPE_COMPLEX,
			'active'=>'complex',
		);
		return view('app.index', $data);
	}

	public function big4List(){
		$page = 1;
		$pagesize = $this->_generate_pagesize();
		$arrGoods = Goods::IndexBig4List($page, $pagesize);
		$arrGoodsIds = Util::column($arrGoods, 'id');
		//获取图片
		$arrGoodsPhoto = GoodsPhoto::getCoverPhotoByGoodsIds($arrGoodsIds);
		$arrGoodsPhoto = Util::setKey($arrGoodsPhoto, 'goods_id');
		foreach($arrGoods as $goods){
			$goods['img_thumb_path'] = isset($arrGoodsPhoto[$goods['id']]) && !isset($goods['img_thumb_path']) ? $arrGoodsPhoto[$goods['id']]['thumb'] : '';
		}
		$arrGoods = Goods::decorateList($arrGoods);
		$data = array(
			'goods'=>$arrGoods,
			'type' =>GoodsType::BIG_TYPE_BIG4,
			'active'=>'big4',
		);
		return view('app.index', $data);
	}

	/**
	 * 处理ajax加载更多
	 */
	public function load_more(Request $request){
		$page = $request->get('page') + 1;
		$type = $request->get('type');
		$pagesize = $this->_generate_pagesize();
		$arrGoods = Goods::load_more($type, $page, $pagesize);
		$arrGoodsIds = Util::column($arrGoods, 'id');
		//获取图片
		$arrGoodsPhoto = GoodsPhoto::getCoverPhotoByGoodsIds($arrGoodsIds);
		$arrGoodsPhoto = Util::setKey($arrGoodsPhoto, 'goods_id');
		foreach($arrGoods as $goods){
			$goods['img_thumb_path'] = isset($arrGoodsPhoto[$goods['id']]) && !isset($goods['img_thumb_path']) ? $arrGoodsPhoto[$goods['id']]['thumb'] : '';
		}
		$arrGoods = Goods::decorateList($arrGoods);
		$arrGoods = Util::laravel_data_to_array($arrGoods);
		return Util::json_format(Protocol::JSEND_SUCCESS, '', $arrGoods);
	}

	/**
	 * 生成导航
	 */
	private function _generate_navbar($type = 'index'){
		$arrNavArea = self::$areaNav;
		$arrNavArea[$type]['active'] = true;
		return $arrNavArea;
	}

	/**
	 * 每页显示条数，如果PC每页15条，如果H5每页5个
	 */
	private function _generate_pagesize(){
		if(Util::isMobile()){
			return 6;
		}
		return 20;
	}

}
