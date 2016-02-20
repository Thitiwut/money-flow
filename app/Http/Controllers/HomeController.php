<?php
namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Session;
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
        return view('home.login');
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
        if ($this->user != null && Session::has('Plan') && Session::get('Plan') != "") {
            $plan   = Plan::find(Session::get('Plan'));
            $months = $plan->months()->get();
            if ($plan) {
                $attach['Month'] = array();
                for ($i = 0; $i < $plan->period; $i++) {
                    $attach['Month'][] = date('F', strtotime('+' . $i . ' month', strtotime($plan->created_at)));
                    if (isset($months[$i])) {
                        $attach['Limit'][]    = $months[$i]->limit;
                        $attach['Progress'][] = $months[$i]->progress;
                    } else {
                        $attach['Limit'][]    = "";
                        $attach['Progress'][] = "";
                    }
                }
                if (isset($months)) {
                    if (isset($months[count($months) - 1])) {
                        $month                  = $months[count($months) - 1];
                        $days                   = $month->days()->get();
                        $attach["Daily"]['Day'] = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                        for ($i = 1; $i <= $attach["Daily"]['Day']; $i++) {
                            $attach["Daily"]["Expense"][$i-1] = 0;
                            $attach["Daily"]["Income"][$i-1]  = 0;
                            foreach ($days as $day) {
                                if ($i == date('d', strtotime($day->date))) {
                                    $attach["Daily"]["Expense"][$i-1] = $day->expense;
                                    $attach["Daily"]["Income"][$i-1]  = $day->income;
                                }
                            }
                        }
                    }
                }
            }
            return view('home.chart')->with($attach);
        }
        return view('home.chart');
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
