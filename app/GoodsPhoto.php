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

	public static $permit_mimetype = array(
		"image/jpeg",
		"image/jpg",
		"image/png",
		"image/gif",
	);

	public static function newGoodsPhoto($goods_id, $photo_path){
		$obj = new GoodsPhoto;
		$obj->goods_id = $goods_id;
		$obj->address = $photo_path;
		$obj->special = self::SPECIAL_NORMAL;
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

}

