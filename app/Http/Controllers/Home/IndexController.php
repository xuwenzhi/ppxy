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
		$data = array(
			'goods'=>array(),
			'type' =>GoodsType::BIG_TYPE_SINGLE,
			'active'=>'index',
			'isMobile' => Util::isMobile(),
		);
		return view('app.index', $data);
	}

	public function complexList(){
		$data = array(
			'goods'=>array(),
			'type' =>GoodsType::BIG_TYPE_COMPLEX,
			'active'=>'complex',
			'isMobile' => Util::isMobile(),
		);
		return view('app.index', $data);
	}

	public function big4List(){
		$data = array(
			'goods'=>array(),
			'type' =>GoodsType::BIG_TYPE_BIG4,
			'active'=>'big4',
			'isMobile' => Util::isMobile(),
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
		$arrGoodCombine = Goods::load_more($type, $page, $pagesize);
		$arrGoods = $arrGoodCombine['list'];
		$total = $arrGoodCombine['total'];

		$has_next_page = $page*$pagesize < $total ? true : false;
		$arrGoodsIds = Util::column($arrGoods, 'id');
		//获取图片
		$arrGoodsPhoto = GoodsPhoto::getCoverPhotoByGoodsIds($arrGoodsIds);
		$arrGoodsPhoto = Util::setKey($arrGoodsPhoto, 'goods_id');
		foreach($arrGoods as $goods){
			$goods['img_thumb_path'] = isset($arrGoodsPhoto[$goods['id']]) && !isset($goods['img_thumb_path']) ? $arrGoodsPhoto[$goods['id']]['thumb'] : '';
		}
		$arrGoods = Goods::decorateList($arrGoods);
		$arrGoods = Util::laravel_data_to_array($arrGoods);
		return Util::json_format(Protocol::JSEND_SUCCESS, '', array('total'=>$total, 'list'=>$arrGoods, 'has_next_page'=>$has_next_page));
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
			return 12;
		}
		return 10;
	}
}
