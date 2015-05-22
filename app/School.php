<?php 
/**
 * 学校类
 * @author 徐文志 358350782@qq.com
 * @time   2015/5/22 22:00:00
 */
namespace App;
class School extends Base {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'school';
	public $timestamps = false;

	public static function getNameById($id){
		$school = School::where(array('id'=>$id))->select('name')->get();
		if($school && !empty($school[0]['name'])){
			return $school[0]['name'];
		}
		return array();
	}
}
