<?php namespace App;

class GoodsPhoto extends Base {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'goods_photo';

	public $timestamps = false;

	const UPLOAD_PATH = "upload/imgs/";

	const SPECIAL_COVER = 'cover';
	const SPECIAL_NORMAL = 'narmal';

	const THUMB = 'thumb_';

	/**
	 * 暂时不用这个，等到升级完阿里云再用这个
	 * @var array
	 */
	public static $permit_mimetype = array(
		"image/jpeg",
		"image/jpg",
		"image/png",
		"image/gif",
	);

	public static $permit_ext = array(
		"GIF",
		"PNG",
		"JPG",
	);

	public static function newGoodsPhoto($goods_id, $photo_path, $thumb_photo_path, $uid = 0){
		$obj = new GoodsPhoto;
		$obj->goods_id = $goods_id;
		$obj->address = $photo_path;
		$obj->special = self::SPECIAL_NORMAL;
		$obj->thumb = $thumb_photo_path;
		$obj->uid = $uid;
		if(!$obj->save()){
			return false;
		}
		return $obj->lastId;
	}

	public static function encryptId($arrData){
		if(!$arrData){
			return array();
		}
		foreach($arrData as $val){
			$val['id'] = Util::encryptData($val['id']);
		}
		return $arrData;
	}

	public static function deleteById($id){
		$objGoodsPhoto = GoodsPhoto::find($id);
		if($objGoodsPhoto->delete()){
			return true;	
		}
		return false;
	}

	/**
	 * 检查该图片是否属于该用户
	 */
	public static function checkIsBelongUser($photo_id, $uid){
		$arrGoodsPhoto = GoodsPhoto::where(array('id'=>$photo_id))->select('uid')->get();
		if(!$arrGoodsPhoto){
			return false;
		}
		if($arrGoodsPhoto[0]['uid'] != $uid){
			return false;
		}
		return true;
	}

}

