<?php 
/**
 * 主页
 */
namespace App\Http\Controllers\Home;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class IndexController extends HomeController {

	protected $boolNeedLogin = true;

	public function index() {
		echo '前台主页';
		var_dump($this->boolNeedLogin);
	}

	

}
