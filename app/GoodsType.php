<?php 
/**
 * 商品类别
 * @author 徐文志 358350782@qq.com
 * @time   2015/5/22 23:20:00
 */
namespace App;
use App\Util;
use Illuminate\Support\Facades\Log;
class GoodsType extends Base {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'goods_type';
	
	public $timestamps = false;

	const SHOW_YES = 'yes';

	/**
	 * 获取商品大类
	 */
	public static function getFirstType(){
		$first_types = GoodsType::where('code', 'like','__')->where(array('show'=>self::SHOW_YES))->select('code', 'name')->get();
		return $first_types;
	}

	/**
	 * 根据商品大类code获取其商品小类	 
	 */
	public static function getSecondTypeByFirst($first_type_code){
		if(!$first_type_code){
			return array();
		}
		$second_types = GoodsType::where('code', 'like', $first_type_code.'_%')->where(array('show'=>self::SHOW_YES))->select('code', 'name')->get();
		return $second_types;
	}

	public static function encryptCode($arrData){
		if(!$arrData){
			return array();
		}
		foreach($arrData as $k => $val){
			$arrData[$k]['code'] = Util::encryptData(intval($val['code']));
		}
		return $arrData;
	}

	public static function getNameByCode($code){
		if(!$code){
			Log::warn('【商品类别code传递错误】');
		}
		$second_types = GoodsType::where(array('code'=>$code))->select('name')->get();
		if($second_types){
			return $second_types[0]['name'];
		}
	}

	/**
	 * 根据小类查找大类code
	 */
	public static function getFirstCodeBySecond($second_code){
		return substr($second_code, 0, 2);
	}

}
