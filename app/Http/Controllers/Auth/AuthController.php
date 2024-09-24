<?php
     
namespace App\Http\Controllers\Auth;
     
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\BaseController as BaseController;
use Illuminate\Auth\Events\Registered;

class AuthController extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
     
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        if ($user) {
            event(new Registered($user));
            
            $success['token'] =  $user->createToken('BaseupAPI')->accessToken;
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
       
            return $this->sendResponse($success, 'User register successfully. Please verify your email.');
        }
    }
     
    /**
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
        
            $user = Auth::user(); 

            if (!$user->hasVerifiedEmail()) {
                $request->user()->sendEmailVerificationNotification();
                return $this->sendError('Email not verified.', ['error' => 'You need to verify your email before logging in.']);
            }

            $success['token'] =  $request->user()->createToken('BaseupAPI')->accessToken; 
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
   
            return $this->sendResponse($success, 'User login successfully.');
        
        } else { 
            return $this->sendError('Wrong credentials. Try again.', ['error'=>'Unauthorized']);
        } 
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request) 
    {
        $request->user()->token()->revoke();

        return $this->sendResponse([], 'User logged out successfully.');
    }
}