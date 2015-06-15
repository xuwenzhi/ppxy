<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller {

	protected $code = null;
	protected $data = array(
		);

	public $objJson = null;

	public function __construct(){
		$objJson = new JsonResponse;
	}

	protected static $arrMsg = array(
		'0' => '处理成功',
		'1' => '数据获取失败',
		'2' => '未找到请求资源',
	);

	protected function send(){

	}

}
