<?php 
/**
 * OauthUser
 * @author 徐文志 358350782@qq.com
 * @time   2015/6/10 23:18:00
 */
namespace App;
use App\Util;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 

class OauthUsers extends Base {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'oauth_users';
	
	public $timestamps = false;

	public static function insert($userInfo){
		return ;
		if(!$userInfo){
			return array();
		}
		$obj = new OauthUsers;
		$obj->username = $userInfo['email'];
		$obj->password = $userInfo['password'];
		$obj->phone    = $userInfo['phone'];
		return $obj->save();
	}

	public static function insertNoRecord($user){
		return ;
		if(!$user){
			return array();
		}
		$recordCount = OauthUsers::where(array('username'=>$user['email']))->count();
		if(!$recordCount){
			return self::insert(array('username'=>$user['email'], 'password'=>($user['password'])));
		}
	}

	public static function updatePass($userInfo){
		return ;
		if(!$userInfo){
			return array();
		}
		$userRecord = OauthUsers::where(array('username'=>$userInfo['email']))->get();
		if(count($userRecord)){
			return DB::table('oauth_users')
            	->where('username', $userInfo['email'])
            	->update(['password' => $userInfo['password'], 'phone'=>$userInfo['phone']]);
		}else{
			return self::insert($userInfo);
		}
	}

}
