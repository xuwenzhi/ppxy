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
class sysnUsersToOauth extends Controller {

	public function run(){
		$arrAllUser = User::where('id', '>', 0)->select('email')->get();
		foreach ($arrAllUser as $key => $user) {
			$obj = new OauthUsers;
			$obj->username = $user['email'];
			$obj->save();
		}
	}

}
