<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use Log;
use Hash;
use function view;
use App\Models\User;

class HomeController extends Controller {
	/*Get Methods*/
	function getIndex(){
		return view('home.index');
	}
	function getLogin(){
		return view('home.login');
	}
	function getRegister(){
		return view('home.register');
	}
	function getCharts(){
		return view('home.charts');
	}
	function getSetting(){
		return view('home.setting');
	}
	function getLogout(){
		Session::flush();
		return redirect('/');
	}

	/*Post*/
	function postLogin(Request $request){
		$message = array(
			'email.exists' => 'Email is not exist!',
			);

		$validator = Validator::make($request->all(), [
			'email' => 'required|exists:user,email',
			'password' => 'required',
			],$message);

		$user = User::where('email','=',$request->email)->first();

		if ($validator->fails()) {
			return redirect()
			->back()
			->withErrors($validator)
			->withInput();
		}

		if(empty($user)){
			if ($validator->fails()) {
				return redirect()
				->back()
				->withErrors(["Username or password are mismatch."])
				->withInput();
			}
		}else{
			$request->session()->put('Auth',$user);
			return redirect('/progress');
		}
	}

	function postRegister(Request $request){
		$message = array(
			'email.exists' => 'Email is not exist!',
			);

		$validator = Validator::make($request->all(), [
			'username' => 'required|unique:user,username',
			'email' => 'required|unique:user,email',
			'password' => 'required|min:6',
			'repassword' => 'required|min:6',
			],$message);

		if ($validator->fails()) {
			return redirect()
			->back()
			->withErrors($validator)
			->withInput();
		}
		if($request->password != $request->repassword){
			return redirect()		
			->back()
			->withErrors('Password is not match!')
			->withInput();
		}

		$user = new User();
		$user->username = $request->username;
		$user->password = $request->password;
		$user->email = $request->email;
		$user->save();

		$request->session()->put('Auth',$user);
		return redirect('/progress');
	}
}