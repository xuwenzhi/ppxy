<?php 
/**
 * OauthClients
 * @author 徐文志 358350782@qq.com
 * @time   2015/6/11 12:40:00
 */
namespace App;
use App\Util;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 

class OauthClients extends Base {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'oauth_clients';
	
	public $timestamps = false;

	public static function insert($userInfo){
		if(!$userInfo){
			return array();
		}
		$obj = new OauthClients;
		$obj->client_id = $userInfo['client_id'];
		$obj->client_secret = $userInfo['client_secret'];
		return $obj->save();
	}

	public static function insertNoRecord($user){
		if(!$user){
			return array();
		}
		$recordCount = OauthClients::where(array('client_id'=>$user['client_id']))->count();
		if(!$recordCount){
			return self::insert(array('client_id'=>$user['client_id'], 'client_secret'=>($user['client_secret'])));
		}
	}

	public static function updatePass($userInfo){
		if(!$userInfo){
			return array();
		}
		$userRecord = OauthClients::where(array('client_id'=>$userInfo['client_id']))->get();
		if(count($userRecord)){
			$userRecord->password = $userInfo['client_secret'];
			return DB::table('oauth_clients')
            	->where('client_id', $userInfo['client_id'])
            	->update(['client_secret' => $userInfo['client_secret']]);
		}else{
			return self::insert($userInfo);
		}
	}

}
