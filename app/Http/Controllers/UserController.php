<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function index(Request $request)
    {	
  		try {
  			$with = request()->with;
  			return response()->default(200, 'OK', User::getData($with));
  		} catch (Exception $e) {
            return response()->default(500, 'Internal server error!');
        }
    }

    public function view(Request $request, string $user)
    {
    	$user = urldecode($user);
    	try {
  			return response()->default(200, 'OK', User::getUser($user));
  		} catch (Exception $e) {
            return response()->default(500, 'Internal server error!');
        }
    }
}
