<?php namespace App\Services;
use Illuminate\Support\Facades\Log;
class Sms {

    public $hp = '';
    public $message = '';
    //签名
    private $sign = 'PP校园';
    private $smsPlatUser = '18345199232';
    private $smsKey      = 'D77C151BEB1265AF779675D0B99E';

    private $sendRes = array(
        0 => '提交成功',
        1 => '含有敏感词汇',
        2 => '余额不足',
        3 => '没有号码',
        4 => '包含sql语句',
        10 => '账号不存在',
        11 => '账号注销',
        12 => '账号停用',
        13 => 'IP鉴权失败',
        14 => '格式错误',
        -1 => '系统异常',
    );

    public function setHp($hp){
        $this->hp = $hp;
        return $this;
    }

    public function setMsg($message){
        $this->message = $message;
        return $this;
    }

    public function sendSingle(){
        return $this->smsInterface($this->hp, $this->message);
    }

    /**
     * 短信发送接口
     * @return 发送结果
     */
    public function smsInterface($hp, $message){
        $flag = 0; 
        $params='';//要post的数据
        $argv = array( 
            'name'=>$this->smsPlatUser,     //必填参数。用户账号
            'pwd'=>$this->smsKey,     //必填参数。（web平台：基本资料中的接口密码）
            'content'=>$message,   //必填参数。发送内容（1-500 个汉字）UTF-8编码
            'mobile'=>$hp,   //必填参数。手机号码。多个以英文逗号隔开
            'stime'=>'',   //可选参数。发送时间，填写时已填写的时间发送，不填时为当前时间发送
            'sign'=>$this->sign,    //必填参数。用户签名。
            'type'=>'pt',  //必填参数。固定值 pt
            'extno'=>''    //可选参数，扩展码，用户定义扩展码，只能为数字
        ); 
        foreach ($argv as $key=>$value) { 
            if ($flag!=0) { 
                $params .= "&"; 
                $flag = 1; 
            } 
            $params.= $key."="; $params.= urlencode($value);// urlencode($value); 
            $flag = 1; 
        } 
        $url = "http://web.cr6868.com/asmx/smsservice.aspx?".$params; //提交的url地址
        $con = substr( file_get_contents($url), 0, 1 );  //获取信息发送后的状态
        if($con != 0){
            Log::error('【短信网关错误】', ['context' => $this->sendRes[$con]]);
        }
        return $con;
    }

}
