<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Base implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * 用户角色
	 */
	const ROLE_PENDING  = 'pending';
	const ROLE_ADMIN    = 'admin';
	const ROLE_MEMBER   = 'member';
	const ROLE_REJECTED = 'pending';

	public static $arrRole = array(
		self::ROLE_PENDING  => '未认证',
		self::ROLE_ADMIN    => '管理员',
		self::ROLE_MEMBER   => '已认证',
		self::ROLE_REJECTED => '已拒绝',
	);

	public static $arrSex = array(
		'notknow' => '未知',
		'male'    => '女',
		'female'  => '男',
 	);

	

}
