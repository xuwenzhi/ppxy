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
use App\User;
use Illuminate\Support\Facades\Session;
use App\Util;
use App\TrafficBrowser;
class HomeController extends Controller {

	protected $boolNeedLogin = true;

	public function __construct(){
		$this->checkLogin();
		//增加浏览量
		$this->addTraffic();
		$isMobile = Util::isMobile();
		if(!$isMobile){
			exit();
		}
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
	public function checkUserRole(){
		$arrLogUser = $this->getLogUser();
		if($arrLogUser){
			if($arrLogUser['role'] == User::ROLE_MEMBER || $arrLogUser['role'] == User::ROLE_ADMIN){
				return true;
			}
		}
		return false;
	}

	public function getPreviousUrl(){
		return Session::previousUrl();
	}

	/**
	 * 增加浏览量
	 */
	public function addTraffic(){
		$device = '';
		if(Util::isMobile()){
			$device = 'mobile';
		}else{
			$device = 'pc';
		}
		$uid = intval($this->getLogUid());
		$objTrafficBrowser = new TrafficBrowser;
		$objTrafficBrowser -> device = $device;
		$objTrafficBrowser -> ip = Util::getIP();
		$objTrafficBrowser -> user_agent = Util::getUserAgent();
		$objTrafficBrowser -> uri = Util::getUri();
		$objTrafficBrowser -> channel = Util::getChannel();
		$objTrafficBrowser -> uid = $uid;
		$objTrafficBrowser->save();
	}

}
