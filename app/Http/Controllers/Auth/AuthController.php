<?php
     
namespace App\Http\Controllers\Auth;
     
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Auth\BaseController as BaseController;
     
class AuthController extends BaseController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
     
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
     
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('OmegaAPI')->accessToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
     
    /**
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
        
            $user = Auth::user(); 
            $success['token'] =  $request->user()->createToken('OmegaAPI')->accessToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        
        } else { 
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
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