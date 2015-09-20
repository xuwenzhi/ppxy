<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use App\OauthUsers;
use App\OauthClients;
class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		//在注册时将用户的信息添加到oauth_users表中，供以后客户端用
		if(!OauthUsers::insert(
			array(
				'username' => $data['email'],
				'password'=>bcrypt($data['password']),
			)
		)){
			return false;
		}
		if(!OauthClients::insert(
			array(
				'client_id' => $data['email'],
				'client_secret'=>bcrypt($data['password']),
			)
		)){
			return false;
		}

		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'created_at' => date('Y-m-d H:i:s'),
		]);
	}

}
