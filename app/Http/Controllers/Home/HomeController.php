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
		//checkLogin
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

}
