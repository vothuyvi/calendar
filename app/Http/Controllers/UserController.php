<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Pacades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\ResponseApi;
class UserController extends Controller {
 /**
  * function login
  * @author Viiii.
  */
  public function login (Request $request) {
    try {
      // lấy recore có username đó
      if (Auth()->attempt(['email' => $request->email, 'password' => $request->password]))
      {
          $user = Auth()->User();
          $token = $user->createToken('MyApp');
          $data=['user' => $user, 'token'=> $token];
          $message="Đăng nhập thành công";
          return ResponseApi::success($data, $message);
      }
      else 
      {
        $message="Username or password wrong";
        return ResponseApi::fails($message, 401);
      }
    } catch (\Exception $e) {
      return ResponseApi::fails("Server Error!");
    }
  }
  /**
   * function register
   * @author Viii.
  */
  public function register (Request $request) {
    try {
      $validator = \Validator::make($request->all(), [
        'email'=> 'required|email',
        'password' => 'required|min:8|max:16',
        'password_confirmation' => 'required|same:password',
      ]);
      $validator->after(function($validator) use ($request) {
        $userItem = User::where('email', $request->email)->first();
        if ($userItem) {
          $validator->errors()->add('email', 'This email has been used');
        }
      });
     
      if($validator->fails()) {
        return ResponseApi::errors($validator->errors());
      }
      else {
        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $message="Register success !";
        return ResponseApi::notifis($message);
      }
    }catch(\Exception $e) {
      return ResponseApi::fails("Server Error!");
    }

  }
  /**
     * function logout
     * @author Vii
     */
  public function logout () 
  {
    if (Auth()->check()) {
       \request()->user()->token()->revoke();
        $message="success";
       return ResponseApi::notifis($message);
    }
  }

  /**
   * get info user
   * @author Vii
   */
  public function getInfo (Request $request) {
    
    return ResponseApi::success(Auth()->User(),'');

  }
}