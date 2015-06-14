<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\OauthUsers;
use App\OauthClients;
use App\User;
class sysnUserToOauth extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'oauth.infosysn';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'users信息同步到oauth';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
		//return [
		//	['example', InputArgument::REQUIRED, 'An example argument.'],
		//];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
		//return [
		//	['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		//];
	}

	function handle(){
		$arrAllUser = User::where('id', '>', 0)->select('email', 'password', 'id', 'phone_nu')->get();
		foreach ($arrAllUser as $key => $user) {
			OauthUsers::updatePass(array('email'=>$user['email'], 'password'=>$user['password'], 'phone'=>$user['phone_nu']));
			OauthClients::updatePass(array('client_id'=>$user['email'], 'client_secret'=>$user['password'], 'phone'=>$user['phone_nu'], 'user_id'=>$user['id']));
		}
	}

}
