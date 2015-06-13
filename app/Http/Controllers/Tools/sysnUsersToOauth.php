<?php 
/**
 * 将已注册的用户同步到oauth_users表中
 * @author  xuwenzhi 358350782@qq.com
 * @date    2015.6.11 1:35
 */

namespace App\Http\Controllers\Tools;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\OauthUsers;
use App\OauthClients;
class sysnUsersToOauth extends Controller {

	public function run(){
		$arrAllUser = User::where('id', '>', 0)->select('email')->get();
		foreach ($arrAllUser as $key => $user) {
			OauthUsers::insertNoRecord(array('email'=>$user['email'], 'password'=>$user['password']));
			OauthClients::insertNoRecord(array('client_id'=>$user['email'], 'client_secret'=>$user['password']));
		}
	}

}
