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
			if(!isset($arrData[$value[$key]])){
				$arrData[$value[$key]] = $value;
			}
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
		$yitian = 86400;
		$yigy = 2592000;
		$yinian = 31104000;
		if($sjcm > $yinian){
			$nian = floor($sjcm/$yinian);
			return $nian."年前";
		}
		else{
			if($sjcm >$yigy){
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

	public static function str_json_format($str = ''){
		return json_encode($str);
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

	public static function reg_price($price = ''){
		if($price == ''){
			return false;
		}
		if(!preg_match("/^(([1-9][0-9]*\.[0-9][0-9]*)|([0]\.[0-9][0-9]*)|([1-9][0-9]*)|([0]{1}))$/", $price)){
			return false;
		}
		return true;
	}

	public static function mask_phone_nu($phone_nu){
		return substr($phone_nu, 0, 3).'****'.substr($phone_nu, 7);
	}

	public static function generate_unique_str($sign = ''){
		return md5(date('ymdhis').''.$sign);
	}

	public static function ext_name($file){
		/*$info = pathinfo($file);
		return $info['extension'];*/
		return 'png';
	}

	public static function is_in_array($str, $arr){
		if(in_array($str, $arr)){
			return true;
		}
		return false;
	}

	/**	
	 * 生成缩略图
	 * @param string     源图绝对完整地址{带文件名及后缀名}
	 * @param string     目标图绝对完整地址{带文件名及后缀名}
	 * @param int        缩略图宽{0:此时目标高度不能为0，目标宽度为源图宽*(目标高度/源图高)}
	 * @param int        缩略图高{0:此时目标宽度不能为0，目标高度为源图高*(目标宽度/源图宽)}
	 * @param int        是否裁切{宽,高必须非0}
	 * @param int/float  缩放{0:不缩放, 0<this<1:缩放到相应比例(此时宽高限制和裁切均失效)}
	 * @return boolean
	 */
	public static function img2thumb($src_img, $dst_img, $width = 200, $height = 200, $cut = 0, $proportion = 0){
	    if(!is_file($src_img)) {
	        return false;
	    }
	    $ot = self::fileext($dst_img);
	    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
	    $srcinfo = getimagesize($src_img);
	    $src_w = $srcinfo[0];
	    $src_h = $srcinfo[1];
	    $type  = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
	    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);
	 
	    $dst_h = $height;
	    $dst_w = $width;
	    $x = $y = 0;
	 
	    /**
	     * 缩略图不超过源图尺寸（前提是宽或高只有一个）
	     */
	    if(($width> $src_w && $height> $src_h) || ($height> $src_h && $width == 0) || ($width> $src_w && $height == 0))
	    {
	        $proportion = 1;
	    }
	    if($width> $src_w)
	    {
	        $dst_w = $width = $src_w;
	    }
	    if($height> $src_h)
	    {
	        $dst_h = $height = $src_h;
	    }
	 
	    if(!$width && !$height && !$proportion)
	    {
	        return false;
	    }
	    if(!$proportion)
	    {
	        if($cut == 0)
	        {
	            if($dst_w && $dst_h)
	            {
	                if($dst_w/$src_w> $dst_h/$src_h)
	                {
	                    $dst_w = $src_w * ($dst_h / $src_h);
	                    $x = 0 - ($dst_w - $width) / 2;
	                }
	                else
	                {
	                    $dst_h = $src_h * ($dst_w / $src_w);
	                    $y = 0 - ($dst_h - $height) / 2;
	                }
	            }
	            else if($dst_w xor $dst_h)
	            {
	                if($dst_w && !$dst_h)  //有宽无高
	                {
	                    $propor = $dst_w / $src_w;
	                    $height = $dst_h  = $src_h * $propor;
	                }
	                else if(!$dst_w && $dst_h)  //有高无宽
	                {
	                    $propor = $dst_h / $src_h;
	                    $width  = $dst_w = $src_w * $propor;
	                }
	            }
	        }
	        else
	        {
	            if(!$dst_h)  //裁剪时无高
	            {
	                $height = $dst_h = $dst_w;
	            }
	            if(!$dst_w)  //裁剪时无宽
	            {
	                $width = $dst_w = $dst_h;
	            }
	            $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
	            $dst_w = (int)round($src_w * $propor);
	            $dst_h = (int)round($src_h * $propor);
	            $x = ($width - $dst_w) / 2;
	            $y = ($height - $dst_h) / 2;
	        }
	    }
	    else
	    {
	        $proportion = min($proportion, 1);
	        $height = $dst_h = $src_h * $proportion;
	        $width  = $dst_w = $src_w * $proportion;
	    }
	 
	    $src = $createfun($src_img);
	    $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
	    $white = imagecolorallocate($dst, 255, 255, 255);
	    imagefill($dst, 0, 0, $white);
	 
	    if(function_exists('imagecopyresampled'))
	    {
	        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	    }
	    else
	    {
	        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	    }
	    $otfunc($dst, $dst_img);
	    imagedestroy($dst);
	    imagedestroy($src);
	    return true;
	}

	public static function fileext($file)
	{
	    return pathinfo($file, PATHINFO_EXTENSION);
	}

	/**
	 * 批量截取content
	 */
	public static function batch_substr_utf8($arrData, $key , $length = 15){
		if(!$arrData){
			return array();
		}
		foreach ($arrData as $value) {
			$value[$key] = self::utf8Substr($value[$key], 0, $length).'...';
		}
		return $arrData;
	}

	//截取utf8字符串 
	public static function utf8Substr($str, $from, $len) { 
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', '$1',$str); 
	} 

	public static function laravel_data_to_array($arrLaravelData){
		$arr = array();
		foreach($arrLaravelData as $key => $val){
			$arr[$key] = $val;
		}
		return $arr;
	}

	public static function get_browser(){
		$agent = $_SERVER["HTTP_USER_AGENT"];
		if(strpos($agent,"MSIE 8.0"))
			return 'IE8';
		else if(strpos($agent,"MSIE 7.0"))
			return 'IE7';
		else if(strpos($agent,"MSIE 6.0"))
			return 'IE6';
		else if(strpos($agent,"Firefox/3"))
			return "FF3";
		else if(strpos($agent,"Firefox/2"))
			return "FF2";
		else if(strpos($agent,"Chrome"))
			return 'chrome';
		else if(strpos($agent,"Safari"))
			return "safari";
		else if(strpos($agent,"Opera"))
			return "Opera";
		return 'other';
	}

}
