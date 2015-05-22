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
	public static function timeTrans($sj) {
	    date_default_timezone_set('PRC');
		$newsjc = time();
	    $fbarr = explode(" ",$sj);
	    $fbsjarr = explode("-",$fbarr[0]);
	    $fbrqarr = explode(":",$fbarr[1]);
	    $fbsjc = mktime($fbrqarr[0],$fbrqarr[1],$fbrqarr[2],$fbsjarr[1],$fbsjarr[2],$fbsjarr[0]);
	    /*    $sjcm是当前时间戳和发表时间戳的差值   */
	    $sjcm = $newsjc - $fbsjc;
	    $yifz = 60;
	    $yixs = 3600;
		$yitian = 864000;
		$yigy = 2592000;
		$yinian = 31104000;
		if($sjcm > $yinian){
			$nian = floor($sjcm/$yinian);
			return $nian."年前";
		} else {
			if($sjcm > $yigy) {
				$yue = floor($sjcm/$yigy);
				return $yue."个月前";
			}
			else{
				if($sjcm >$yitian){
					$tian = floor($sjcm/$yitian);
					return $tian."天前";
				}
				else{
					if($sjcm >$yixs){
						$xiaoshi = floor($sjcm/$yixs);
						return $xiaoshi."小时前";
					}
					else{
						if($sjcm >$yifz){
							$fenzhong = floor($sjcm/$yifz);
							return $fenzhong."分钟前";
						}
						else{
								return "刚刚";
						}
					}
				}
			}
		}

	}

	/**
	 * 判断客户端是否是移动浏览器
	 */
	public static function isMobile(){ 
	    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
	    if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
	        return true;
	    } 
	    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
	    if (isset ($_SERVER['HTTP_VIA'])){ 
	        // 找不到为flase,否则为true
	        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
	    } 
	    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
	    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
	        $clientkeywords = array ('nokia',
	            'sony',
	            'ericsson',
	            'mot',
	            'samsung',
	            'htc',
	            'sgh',
	            'lg',
	            'sharp',
	            'sie-',
	            'philips',
	            'panasonic',
	            'alcatel',
	            'lenovo',
	            'iphone',
	            'ipod',
	            'blackberry',
	            'meizu',
	            'android',
	            'netfront',
	            'symbian',
	            'ucweb',
	            'windowsce',
	            'palm',
	            'operamini',
	            'operamobi',
	            'openwave',
	            'nexusone',
	            'cldc',
	            'midp',
	            'wap',
	            'mobile'
	            ); 
	        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
	        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
	        {
	            return true;
	        } 
	    } 
	    // 协议法，因为有可能不准确，放到最后判断
	    if (isset ($_SERVER['HTTP_ACCEPT']))
	    { 
	        // 如果只支持wml并且不支持html那一定是移动设备
	        // 如果支持wml和html但是wml在html之前则是移动设备
	        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
	        {
	            return true;
	        } 
	    } 
	    return false;
	}

	public static function json_format($code, $message = '', $data = array()) {
		$res = array(
				'status' => $code,
				'message' => $message,
				'data'    => $data, 
			);
		return json_encode($res);
	}

	public static function errorResponse($msg = "", $code = 1) {
	    return array('code' => $code, 'message' => $msg);
	}

	/*
	 * help function to create success reponse array
	 * default code is 0, means success
	 */
	public static function successResponse($msg = ""){
	    return array('code' => 0, 'message' => $msg);
	}

	public static function reg_phone_nu($phone_nu){
		if(preg_match("/1[34589]{1}\d{9}$/",$phone_nu)){  
		     return true;
		}else{  
		 	 return false;
		}
	}

	public static function reg_verify_code($code){
		if(preg_match("/\d{6}$/",$code)){  
		     return true;
		}else{  
		 	 return false;
		}
	}




}
