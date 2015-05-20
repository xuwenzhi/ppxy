<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\AdminController;
use App\User;
class IndexController extends AdminController {
	
	public function index() {
		$data = array(
        	'name' => 'Laravel',
	    );  
	    return view('admin.index', $data);
	}

}
