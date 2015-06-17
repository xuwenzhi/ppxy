<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ApiController extends Controller {

	protected $code = null;
	protected $data = array(
	);

	/**
	 * 错误码对应msg
	 * @var array
	 */
	protected static $arrMsg = array(
		'0' => '处理成功',
		'1' => '数据获取失败',
		'2' => '未找到请求资源',
		'3' => '好像不是正确的手机号,换一个吧',
		'4' => '这个手机号已经注册过了',
		'5' => '您本日的验证次数过多,请明日再试',
		'6' => '验证码发送失败,请您重试',
		'7' => '您的验证码输入错误,请重新填写',
		'8' => '非常抱歉,系统错误,请重试。',
		'9' => '您提交的信息不完整,请您重试',
		'10'=> '抱歉,您的昵称和密码添加失败,请重试',
	);


	protected function send($code,  $message = '', $data = array()){
		echo json_encode(array(
							'code'    => $code,
							'message' => $message != '' ? $message : self::$arrMsg[$code],
							'data'    => $data,
                        ));
		return ;
	}

}
