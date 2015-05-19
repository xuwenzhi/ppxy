<?php
/**
 * 公共方法类  
 * @author 徐文志 358350782@qq.com
 * @date   2015/05/19 22:56
 */
namespace App;

class Util {
	
	public static function column($arrData, $column = 'id') {
		$arrTmp = array();
		foreach ($arrData as $value) {
			if(!empty($value[$column])){
				$arrTmp[] = $value[$column];
			}
		}
		return $arrTmp;
	}

	public static function setKey($arrData, $key = 'id') {
		foreach ($arrData as $value) {
			$arrData[$value[$key]] = $value;
		}
		return $arrData;
	}
}
