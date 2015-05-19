<?php 
namespace App\Http\Controllers\Admin;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller {

	protected $strAdminRole = null;

	protected $intPageSize = 20;

	public function __construct() {
		$this->middleware('auth');
		$this->checkRole();
	}

	protected function checkRole(){
		$arrUser = $this->getLogUser();
		$this->strAdminRole = $arrUser['role'];
	}

	protected function getLogUser(){
		$arrUser = \Auth::user();
		return $arrUser;
	}

	protected function toLog(){
		return Redirect::to('/home');
	}

}
