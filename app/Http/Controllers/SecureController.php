<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;

class SecureController extends Controller
{
	protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

	public function profile(Request $request)
	{
		try {
			$user = $this->auth
					 ->user()
					 ->only(['id', 'fullname', 'email']);
					 
  			return response()->default(200, 'OK', $user);
  		} catch (Exception $e) {
            return response()->default(500, 'Internal server error!');
        }
		return $user;
	}
}