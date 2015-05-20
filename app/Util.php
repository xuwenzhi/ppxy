<?php
/**
 * 公共方法类  
 * @author 徐文志 358350782@qq.com
 * @date   2015/05/19 22:56
 */
namespace App;
use Illuminate\Support\Facades\Crypt;

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

	public static function encryptData($in, $to_num = false, $pad_up = false, $pass_key = null) {
	  	$out   =   '';
	  	$index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	  	$base  = strlen($index);
	  	if ($pass_key !== null) {
	    	for ($n = 0; $n < strlen($index); $n++) {
	      		$i[] = substr($index, $n, 1);
	    	}
		    $pass_hash = hash('sha256',$pass_key);
		    $pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

		    for ($n = 0; $n < strlen($index); $n++) {
		      	$p[] =  substr($pass_hash, $n, 1);
		    }
		    array_multisort($p, SORT_DESC, $i);
		    $index = implode($i);
	  	}
	  	if ($to_num) {
		    $len = strlen($in) - 1;

		    for ($t = $len; $t >= 0; $t--) {
		      	$bcp = bcpow($base, $len - $t);
		      	$out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
		    }

		    if (is_numeric($pad_up)) {
		      	$pad_up--;
		      	if ($pad_up > 0) {
		        	$out -= pow($base, $pad_up);
		      	}
		    }
	  	} else {
	    	if (is_numeric($pad_up)) {
	      		$pad_up--;
	      		if ($pad_up > 0) {
	        		$in += pow($base, $pad_up);
	      		}
	    	}
		    for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
		      	$bcp = bcpow($base, $t);
		      	$a   = floor($in / $bcp) % $base;
		     	$out = $out . substr($index, $a, 1);
		      	$in  = $in - ($a * $bcp);
		    }
	  	}
	  	return $out;
	}

	/**
	 * 时间转换
	 */
	public static function timeTrans($time = NULL) {
	    return '5小时前';
	}



}
