<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Http\Request;
use Session;
use Validator;

class AdminController extends Controller
{
    /*Get*/
    public function getIndex(Request $request)
    {
        return view('admin.index');
    }
    public function getUsers(Request $request)
    {
        if (Session::has('Admin')) {
            $users = User::orderBy('id', 'desc')->paginate(20);
            return view('admin.user', ['users' => $users]);
        } else {
            return redirect("admin");
        }

    }
    public function getFeedbacks(Request $request)
    {
        if (Session::has('Admin')) {
            $feedbacks = Feedback::orderBy('id', 'desc')->paginate(20);
            return view('admin.feedback', ['feedbacks' => $feedbacks]);
        } else {
            return redirect("admin");
        }
    }
    /*Post*/
    public function postIndex(Request $request)
    {
        $message = array(
            'username.exists' => 'Admin is not exist!',
        );

        $validator = Validator::make($request->all(), [
            'username' => 'required|exists:admin,username',
            'secret'   => 'required',
            'password' => 'required',
        ], $message);

        $admin = Admin::where('username', '=', $request->username)->first();

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!empty($user)) {
            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors(["Username or password are mismatch."])
                    ->withInput();
            }
        } else {
            if ($admin->password === $request->password && $admin->secret === $request->secret) {
                $request->session()->put('Auth', $admin);
                $request->session()->put('Admin', true);
                return redirect('admin/users');
            }
        }
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
    }
    public function postDeleteUser(Request $request)
    {
        if (Session::has('Admin')) {
            $user = User::find($request->id);
            if ($user) {
                foreach ($user->plans()->get() as $plan) {
                    $monthly   = $plan->months()->get();
                    $restricts = $plan->restricts()->get();
                    foreach ($monthly as $month) {
                        $daily = $month->days()->get();
                        foreach ($daily as $key => $day) {
                            $finances = $day->finances()->get();
                            foreach ($finances as $finance) {
                                $finance->delete();
                            }
                            $day->delete();
                        }
                        $month->delete();
                    }
                    foreach ($restricts as $restrict) {
                        $restrict->delete();
                    }
                    $plan->delete();
                }
                $user->delete();
            }
            return redirect()->back();
        } else {
            return redirect("admin");
        }
    }
    public function getLogout()
    {
        Session::flush();
        return redirect('/');
    }
}
