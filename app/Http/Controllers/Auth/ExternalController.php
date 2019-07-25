<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ExternalController extends Controller
{
	use AuthenticatesUsers;

	public function login(Request $request){
		$data = decrypt($request->data);
		$request->request->add([
			'email'    => $data['email'],
			'password' => $data['password']
		]);
		
		//dd($request->all());
		/*dd(decrypt($data));
    	return response()->json([
	    		'response' => [
	    			'code' => 1,
	    			'msg'  => 'Error',
                    'validation' => ''
	    		],
	    		'data'       => []
	    	], 200);
		*/
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            if ($user->active && $this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            } else {
                $this->incrementLoginAttempts($request);
                return $this->sendFailedLoginResponse($request);
            }
        }
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);

    }
}
