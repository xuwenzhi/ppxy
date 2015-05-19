<?php 
/**
 * 主页
 */
namespace App\Http\Controllers\Home;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class IndexController extends HomeController {

	protected $boolNeedLogin = false;

	public function index() {
		$data = array();
		return view('app.index', $data);
	}

	

}
