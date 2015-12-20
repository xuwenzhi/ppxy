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
use App\Services\Protocol;
use Illuminate\Http\Response;

class GoodsController extends HomeController {

	protected $boolNeedLogin = false;

	/**
	 * 发布新商品页面
	 */
	public function tplNew() {
		//检查用户是否已经验证手机号
		if(!$this->checkUserRole()){			
			return Redirect::to('/verify/newgoods');
		}
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
		$objGoods->title = htmlspecialchars($arrData['goods_title']);
		$objGoods->type = $arrData['goods_type'];
		$objGoods->price = $arrData['goods_price'];
		$objGoods->content = htmlspecialchars(trim($arrData['goods_content']));
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
		$arrPhoto = GoodsPhoto::encryptId($arrPhoto);
		$arrGoods = $arrGoods[0];
		if($uid) {
			$arrSame = Goods::getSameTypeGoods($arrGoods['type'], $id, array($uid));
		}else{
			$arrSame = Goods::getSameTypeGoods($arrGoods['type'], $id);
		}
		$arrSame = Goods::decorateList($arrSame);
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
			'recommend_widget_title' => '同类货',
			'recommend_widget_body'=>$arrSame,
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
		$uid = $this->getLogUid();
		$arrGoods = Goods::getUserAllGoods($uid, 1, 6);
		$arrGoods = $arrGoods['list'];
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
			'isMobile' => Util::isMobile(),
		);
		return view('app.goods.mine', $data);
	}

	public function ajax_mine(Request $request){
		$page = $request->get('page') + 1;
		$pagesize = 6;
		$uid = $this->getLogUid();
		$arrGoods = Goods::getUserAllGoods($uid, $page, $pagesize);
		$arrGoods = $arrGoods['list'];
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
	 * 修改商品信息
	 */
	public function modify($enId){
		$id = intval(Util::encryptData($enId, true));
		if(!$id){
			return Redirect::to('/404');
		}
		$arrGoods = Goods::where(array('id' => $id)) -> get();
		$arrGoods = $arrGoods[0];
		$uid = $this->getLogUid();
		if($arrGoods['uid'] != $uid){
			return Redirect::to('/404');
		}
		$goods_types = GoodsType::getFirstType();
		$second_types = array();
		if($goods_types){
			$crt_first_type_code = GoodsType::getFirstCodeBySecond($arrGoods['type']);
			$second_types = GoodsType::getSecondTypeByFirst($crt_first_type_code);
		}
		$goods_types = GoodsType::encryptCode($goods_types);
		$second_types = GoodsType::encryptCode($second_types);
		$crt_first_type_code = Util::encryptData($crt_first_type_code);
		$arrGoods['id'] = Util::encryptData($arrGoods['id']);
		$arrGoods['type'] = Util::encryptData($arrGoods['type']);
		$arrPhoto = GoodsPhoto::whereIn('goods_id', array($id))->get();
		$arrPhoto = GoodsPhoto::encryptId($arrPhoto);
		$data = array(
			'goods' => $arrGoods,
			'types'=>$goods_types,
			'second_types'=>$second_types,
			'photos'=>$arrPhoto,
			'new_level' =>Goods::$arrNewLevel,
			'crt_first_type_code' => $crt_first_type_code,
			'isMobile'=>Util::isMobile(),
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

	

	public function upload(Request $request){
		$file = $request -> file('Filedata');
		if (!$file -> isValid()) {
		    echo 'error*图片过大,请重新选择,请控制在2M以下。';
		    return ;
			exit();
		}
		$goods_id = Util::encryptData($request->get('goodsenid'), true);
		//todo 
		$mimeType = $file->getMimeType();
		if(!Util::is_in_array($mimeType, GoodsPhoto::$permit_mimetype)){
		 	echo 'error*图片格式错误,请重新选择。';
		 	return ;
		 	exit();
		}
		$upload_path = GoodsPhoto::UPLOAD_PATH."".date('Y-m-d');
		if(!is_dir($upload_path)){
			if(!mkdir($upload_path)){
				Log::error("【创建路径失败】- 路径为".$upload_path);
				echo 'error*上传失败,请重试。';
				return ;
				exit();
			}
		}
		//生成一个新名称
		$origin_name = $file -> getClientOriginalName();
		$extension_name = Util::ext_name($origin_name);
		if(!Util::is_in_array(strtoupper($extension_name), GoodsPhoto::$permit_ext)){
			echo 'error*图片格式错误,请重新选择。';
			return ;
		 	exit();
		}
		$new_name = Util::generate_unique_str($origin_name).'.'.$extension_name;
		if(!$file -> move($upload_path, $new_name)){
			return Util::json_format('error', '图片上传失败,请重试。');
			echo 'error*图片上传失败,请重试。';
			return ;
			exit();
		}
		//生成缩略图
		$public_path = str_replace('\\', '/', public_path());
		$thumb_name = GoodsPhoto::THUMB.$new_name;
		$big_img_path = $public_path.'/'.$upload_path.'/'.$new_name;
		$thumb_img_path = $public_path.'/'.$upload_path.'/'.$thumb_name;
		if(!Util::img2thumb($big_img_path, $thumb_img_path)){
			return Util::json_format('error', '图片上传失败,请重试。');
			echo 'error*图片上传失败,请重试。';
			return ;
			exit();
		}
		$big_img_system_path   = $upload_path.'/'.$new_name;
		$small_img_system_path = $upload_path.'/'.$thumb_name;
		$new_photo_id = GoodsPhoto::newGoodsPhoto($goods_id, $big_img_system_path, $small_img_system_path, $this->getLogUid());
		$new_photo_id = Util::encryptData($new_photo_id);
		echo 'success*'.$small_img_system_path.'*'.$new_photo_id.'*'.$big_img_system_path;
		exit;
	}

	public function doModify(Request $request){
		$arrRequest = $request -> all();
		//数据检查
		if(!$this->checkPostGoods($arrRequest)){
			return Redirect::to('/404');
		}
		$uid = $this->getLogUid();
		$arrRequest['uid'] = $uid;
		$arrRequest['goods_type'] = Util::encryptData($arrRequest['goods_type'], true);
		$arrRequest['id'] = Util::encryptData($arrRequest['goods_enid'], true);
		$update_res = $this->_update($arrRequest);
		if($update_res){
			return Redirect::to('/goods/detail/'.$arrRequest['goods_enid']);
		} else {
			return Redirect::to('/goods/modify/'.$arrRequest['goods_enid']);
		}
	}

	private function _update($arrData){
		$objGoods = Goods::find($arrData['id']);
		$objGoods->title = $arrData['goods_title'];
		$objGoods->type = $arrData['goods_type'];
		$objGoods->price = $arrData['goods_price'];
		$objGoods->content = trim($arrData['goods_content']);
		$objGoods->deal_place_ext = $arrData['goods_dealplace_ext'];
		$res = $objGoods->save();
		if(!$res){
			Log::error('【修改商品报错】', ['context' => $arrData]);
			return array();
		}
		return $res;
	}

	public function doDeletePhoto(Request $request){
		$goods_photo_id = Util::encryptData($request->get('photo_enid'), true);
		if(!$goods_photo_id){
			return Util::json_format(Protocol::JSEND_FAILED, '删除失败,请重试。');
		}
		$uid = $this->getLogUid();
		if(!$uid){
			return Util::json_format(Protocol::JSEND_FAILED, '请重新登录');
		}
		//检查当前的图片是否属于这个用户
		if(!GoodsPhoto::checkIsBelongUser($goods_photo_id, $uid)){
			return Util::json_format(Protocol::JSEND_ILLEGAL, '非法操作！');
		}
		if(GoodsPhoto::deleteById($goods_photo_id)){
			return Util::json_format(Protocol::JSEND_SUCCESS, '删除成功');	
		}
		return Util::json_format(Protocol::JSEND_ERROR, '删除失败,请重试。');
	}

	public function surprise($type){
		$strShow = '';
		$arrType = array(
				'null' => '没有找到这货，卖家把它下架了~',
				'seckill'=>'这货已经被其他人抢走了，下次手要快噢~',
			);
		$strShow = isset($arrType[$type]) ? $arrType[$type] : $arrType['null'];
		$data = array(
			'show' => $strShow,
		);
		return view('app.goods.surprise', $data);
	}

	/**
	 * 商品暂不处理 商品状态修改
	 * @author jv
	 */
	public function ajax_status(Request $request){
		$goods_id = intval(Util::encryptData($request->get('enId'), true));
		$status   = $request->get('to_be_status');
		if(!isset(Goods::$arrStatus[$status])){
			return Util::json_format(Protocol::JSEND_ERROR,'提交错误,建议您刷新浏览器重试');
		}
		$arrGoods = Goods::find($goods_id);
		if($arrGoods['uid'] != $this->getLogUid()){
			return Util::json_format(Protocol::JSEND_ILLEGAL,'非法操作!');	
		}
		$objGoods = Goods::find($goods_id);
		$objGoods->status = $status;
		$res = $objGoods->save();
		if (!$res) {
			return Util::json_format(Protocol::JSEND_ERROR,'修改商品状态失败');
		}
		return Util::json_format(Protocol::JSEND_SUCCESS,'修改商品状态成功，将在刷新浏览器后生效。');
	}

	public function uploadImgReturnPath(Request $request){
		$file = $request -> file('Filedata');
		if (!$file -> isValid()) {
		    echo Protocol::JSEND_ERROR.'*图片过大,请控制在2M以下。';
		    return;
		}
		$goods_id = Util::encryptData($request->get('goods_enid'), true);
		//todo 
		$mimeType = $file->getMimeType();
		if(!Util::is_in_array($mimeType, GoodsPhoto::$permit_mimetype)){
		 	echo Protocol::JSEND_ERROR.'*图片格式错误,请重新选择';
			return ;
		}
		$upload_path = GoodsPhoto::UPLOAD_PATH."".date('Y-m-d');
		if(!is_dir($upload_path)){
			if(!mkdir($upload_path)){
				Log::error("【创建路径失败】- 路径为".$upload_path);
				echo Protocol::JSEND_ERROR.'*图片上传失败,请重试';
				return ;
			}
		}
		//生成一个新名称
		$origin_name = $file -> getClientOriginalName();
		$extension_name = Util::ext_name($origin_name);
		if(!Util::is_in_array(strtoupper($extension_name), GoodsPhoto::$permit_ext)){
			echo Protocol::JSEND_ERROR.'*图片上传失败,请重试';
			return ;
		}
		$new_name = Util::generate_unique_str($origin_name).'.'.$extension_name;
		if(!$file -> move($upload_path, $new_name)){
			echo Protocol::JSEND_ERROR.'*图片上传失败,请重试';
			return ;
		}
		//生成缩略图
		$public_path = str_replace('\\', '/', public_path());
		$thumb_name = GoodsPhoto::THUMB.$new_name;
		$big_img_path = $public_path.'/'.$upload_path.'/'.$new_name;
		$thumb_img_path = $public_path.'/'.$upload_path.'/'.$thumb_name;
		if(!Util::img2thumb($big_img_path, $thumb_img_path)){
			echo Protocol::JSEND_ERROR.'*图片上传失败,请重试';
			return ;
		}
		$big_img_system_path   = $upload_path.'/'.$new_name;
		$small_img_system_path = $upload_path.'/'.$thumb_name;
		$new_photo_id = GoodsPhoto::newGoodsPhoto($goods_id, $big_img_system_path, $small_img_system_path, $this->getLogUid());
		$new_photo_id = Util::encryptData($new_photo_id);
		echo Protocol::JSEND_SUCCESS.'*'.$new_photo_id.'*'.$small_img_system_path.'*'.$big_img_system_path;
		return ;
	}

	/**
	 *	搜索商品
	 *  @author JV
	 */
	public function lookFor(Request $request){
		$keyword = $request->route('keyword');
		$keyword = urldecode(str_replace('ppxy','%', $keyword));
		$arrGoods = Goods::find_goods($keyword,1,$this->_generate_pagesize());
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
			'keyword'=>$keyword,
			'isMobile'=>Util::isMobile(),
		);
		return view('app.goods.search', $data);
	}

	/*
	*搜索物品加载更多
	*
	*/
	public function ajax_lookfor(Request $request){
		$page = $request->get('page') + 1;
		$keyword = $request->get('keyword');
		$pagesize = 6;
		$arrGoods = Goods::find_goods($keyword, $page, $pagesize);
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
	 * 每页显示条数，如果PC每页15条，如果H5每页7个
	 */
	private function _generate_pagesize(){
		if(Util::isMobile()){
			return 7;
		}
		return 15;
	}

}
