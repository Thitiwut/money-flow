<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    /*Get Methods*/
    public function getIndex()
    {
        return view('home.index');
    }
    public function getLogin()
    {
        return view('home.login');
    }
    public function getRegister()
    {
        return view('home.register');
    }
    public function getCharts()
    {
        return view('home.charts');
    }
    public function getSetting()
    {
        return view('home.setting');
    }
    public function getLogout()
    {
        Session::flush();
        return redirect('/');
    }

    /*Post*/
    public function postLogin(Request $request)
    {
        $message = array(
            'email.exists' => 'Email is not exist!',
        );

        $validator = Validator::make($request->all(), [
            'email'    => 'required|exists:user,email',
            'password' => 'required',
        ], $message);

        $user = User::where('email', '=', $request->email)->first();

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (empty($user)) {
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors(["Username or password are mismatch."])
                    ->withInput();
            }
        } else {
            $request->session()->put('Auth', $user);
            return redirect('/progress');
        }
    }

    public function postRegister(Request $request)
    {
        $message = array(
            'email.exists' => 'Email is not exist!',
        );

        $validator = Validator::make($request->all(), [
            'username'   => 'required|unique:user,username',
            'email'      => 'required|unique:user,email',
            'password'   => 'required|min:6',
            'repassword' => 'required|min:6',
        ], $message);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->password != $request->repassword) {
            return redirect()
                ->back()
                ->withErrors('Password is not match!')
                ->withInput();
        }

        $user           = new User();
        $user->username = $request->username;
        $user->password = $request->password;
        $user->email    = $request->email;
        $user->save();

        $request->session()->put('Auth', $user);
        return redirect('/progress');
    }

}
