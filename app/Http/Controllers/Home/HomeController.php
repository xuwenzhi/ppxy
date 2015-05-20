<?php 
/**
 * 前台基类
 * @author 徐文志 <358350782@qq.com>
 * @date  2015/5/18 20:31
 */
namespace App\Http\Controllers\Home;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class HomeController extends Controller {

	protected $boolNeedLogin = true;

	public function __construct(){
		$this->checkLogin();
	}

	/**
	 * check login
	 */
	protected function checkLogin(){
		if($this->boolNeedLogin){
			$this->middleware('auth');
		}
	}

	protected function getLogUid(){
		$arrUser = $this->getLogUser();
		if($arrUser){
			return $arrUser['id'];
		}
		return array();
	}

	protected function getLogUser(){
		$arrUser = \Auth::user();
		return $arrUser;
	}

	/**
	 * 检查用户是否有购买或发布商品权限
	 */
	public static function checkUserRole(){
		$arrLogUser = $this->getLogUser();
		if($arrLogUser){
			if($arrLogUser[0]['role'] == self::ROLE_MEMBER || $arrLogUser[0]['role'] == self::ROLE_ADMIN){
				return true;
			}
		}
		return false;
	}

}
