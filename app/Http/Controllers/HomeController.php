<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Feedback;
use App\Models\Finance;
use App\Models\Monthly;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;
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
    public function getCharts(Request $request)
    {
        if ($this->user != null && Session::has('Plan') && Session::get('Plan') != "") {
            $plan = Plan::find(Session::get('Plan'));
            if ($plan) {
                $months              = $plan->months()->get();
                $attach["Plan"]      = $plan;
                $attach["MonthList"] = $months;
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
                    $attach["Daily"] = array();
                    if (isset($months)) {
                        if (isset($months[count($months) - 1])) {
                            $month = $months[count($months) - 1];
                            $days  = $month->days()->get();

                            $attach["Daily"]['Day'] = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                            for ($i = 1; $i <= $attach["Daily"]['Day']; $i++) {
                                $attach["Daily"]["Expense"][$i - 1] = 0;
                                $attach["Daily"]["Income"][$i - 1]  = 0;
                                foreach ($days as $day) {
                                    if ($i == date('d', strtotime($day->date))) {
                                        $attach["Daily"]["Expense"][$i - 1] = $day->expense;
                                        $attach["Daily"]["Income"][$i - 1]  = $day->income;
                                    }
                                }
                            }
                        }
                    }
                    $attach["Category"] = array();
                    if ($request->month != null) {
                        $month                = Monthly::find($request->month);
                        $categories           = Category::where('user_id', '=', $this->user->id)->orWhere('user_id', '=', 0)->get();
                        $start                = date('Y-m-d', strtotime('+' . $month->month - 1 . ' month', strtotime($plan->created_at)));
                        $end                  = date('Y-m-d', strtotime('+' . $month->month . ' month', strtotime($plan->created_at)));
                        $attach["SumIncome"]  = 0;
                        $attach["SumExpense"] = 0;
                        foreach ($categories as $key => $value) {
                            $expense = Finance::join('category', 'category.id', '=', 'finance.category_id')
                                ->join('daily', 'daily.id', '=', 'finance.daily_id')
                                ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                                ->where('monthly.id', '=', $month->id)
                                ->where('finance.category_id', '=', $value->id)
                                ->where('type', '=', 0)
                                ->where('daily.date', '>=', $start)
                                ->where('daily.date', '<=', $end)
                                ->sum('amount');
                            $attach["SumExpense"] += $expense;

                            $income = Finance::join('category', 'category.id', '=', 'finance.category_id')
                                ->join('daily', 'daily.id', '=', 'finance.daily_id')
                                ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                                ->where('monthly.id', '=', $month->id)
                                ->where('finance.category_id', '=', $value->id)
                                ->where('type', '=', 1)
                                ->where('daily.date', '>=', $start)
                                ->where('daily.date', '<=', $end)
                                ->sum('amount');
                            $attach["SumIncome"] += $income;

                            $rand = dechex(rand(0x000000, 0xFFFFFF));
                            if (intval($expense) > 0 || intval($income) > 0) {
                                $attach["Category"][$value->name]["expense"] = $expense;
                                $attach["Category"][$value->name]["income"]  = $income;
                                $attach["Category"][$value->name]["color"]   = $rand;
                            }

                        }
                    }
                }
                return view('home.chart')->with($attach);
            }
        }
        return redirect('/progress');
    }
    public function getSetting()
    {
        $attach['user'] = $this->user;
        return view('home.setting', $attach);
    }
    public function getLogout()
    {
        Session::flush();
        return redirect('/');
    }
    public function getSearch(Request $request)
    {
        $attach['categories'] = Category::where("user_id", "=", "0")->orWhere("user_id", "=", $this->user->id)->get();
        $attach['user']       = $this->user;
        if (isset($request->keyword)) {
            $attach['keyword'] = $request->keyword;
            $cat               = '';
            if (isset($request->cat)) {
                $cat                = $request->cat;
                $attach['finances'] = Finance::select('finance.name', 'category.name AS category', 'finance.created_at', 'plan.name AS plan', 'finance.type', 'finance.amount')
                    ->join('category', 'category.id', '=', 'finance.category_id')
                    ->join('daily', 'daily.id', '=', 'finance.daily_id')
                    ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                    ->join('plan', 'plan.id', '=', 'monthly.plan_id')
                    ->where('finance.name', 'like', "%$request->keyword%")
                    ->where('category.id', '=', $cat)
                    ->paginate(20);
            } else {
                $attach['finances'] = Finance::select('finance.name', 'category.name AS category', 'finance.created_at', 'plan.name AS plan', 'finance.type', 'finance.amount')
                    ->join('category', 'category.id', '=', 'finance.category_id')
                    ->join('daily', 'daily.id', '=', 'finance.daily_id')
                    ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                    ->join('plan', 'plan.id', '=', 'monthly.plan_id')
                    ->where('finance.name', 'like', "%$request->keyword%")
                    ->paginate(20);
            }
            return view('home.search', $attach);
        }
        return view('home.search');
    }
    public function getFeedback()
    {
        return view('home.feedback');
    }
    public function getReport(Request $request)
    {
        if ($this->user != null && Session::has('Plan') && Session::get('Plan') != "") {
            $plan                = Plan::find(Session::get('Plan'));
            $attach["plan"]      = $plan;
            $attach["Month"]     = $plan->months()->get();
            $attach["Category"]  = Category::where('user_id', '=', $this->user->id)->orWhere('user_id', '=', 0)->get();
            $attach['sumIncome'] = Finance::join('category', 'category.id', '=', 'finance.category_id')
                ->join('daily', 'daily.id', '=', 'finance.daily_id')
                ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                ->join('plan', 'plan.id', '=', 'monthly.plan_id')
                ->where('plan.id', '=', $plan->id)
                ->where('type', '=', 1)
                ->sum('amount');
            $attach['sumExpense'] = Finance::join('category', 'category.id', '=', 'finance.category_id')
                ->join('daily', 'daily.id', '=', 'finance.daily_id')
                ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                ->join('plan', 'plan.id', '=', 'monthly.plan_id')
                ->where('plan.id', '=', $plan->id)
                ->where('type', '=', 0)
                ->sum('amount');
            if (isset($request->category) && isset($request->month)) {
                $cat   = $request->category;
                $month = $request->month;
                $query = Finance::select('finance.name', 'category.name AS category', 'finance.created_at', 'plan.name AS plan', 'finance.type', 'finance.amount')
                    ->join('category', 'category.id', '=', 'finance.category_id')
                    ->join('daily', 'daily.id', '=', 'finance.daily_id')
                    ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                    ->join('plan', 'plan.id', '=', 'monthly.plan_id');

                if ($cat != 0) {
                    $query->where('category.id', '=', $cat);
                }
                if ($month != 0) {
                    $query->where('monthly.id', '=', $month);
                }
                $query->where('plan.id', '=', $plan->id);
                $attach['finances'] = $query->paginate(20);
                // $attach['finances'] = Finance::select('finance.name', 'category.name AS category', 'finance.created_at', 'plan.name AS plan', 'finance.type', 'finance.amount')
                //     ->join('category', 'category.id', '=', 'finance.category_id')
                //     ->join('daily', 'daily.id', '=', 'finance.daily_id')
                //     ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                //     ->join('plan', 'plan.id', '=', 'monthly.plan_id')
                //     ->where('category.id', '=', $cat)
                //     ->where('monthly.id', '=', $month)
                //     ->where('plan.i', '=', $plan->id)
                //     ->paginate(20);
            }
            return view('home.report', $attach);
        } else {
            return view('home.report');
        }
    }
    /*Post*/
    public function postFeedback(Request $request)
    {
        $feedback           = new Feedback();
        $feedback->feedback = $request->feedback;
        $feedback->user_id  = $this->user->id;
        $feedback->save();
        Session::forget("successes");
        Session::put('successes', ["Feedback is send to admin. Thanks for helping us!"]);
        return view('home.feedback');
    }
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
    public function postUpdate(Request $request)
    {
        $message = array(
        );

        $validator = Validator::make($request->all(), [
            'password'   => 'min:6',
            'repassword' => 'min:6',
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

        $user = User::find($this->user->id);
        if ($request->username != null && $request->username != $user->username) {
            $user->username = $request->username;
        }
        if ($request->password != null && $request->password != $user->password) {
            $user->password = $request->password;
        }
        if ($request->email != null && $request->email != $user->email) {
            $user->email = $request->email;
        }
        $user->save();
        $request->session()->put('Auth', $user);
        return redirect('/setting');
    }
    public function postNotification(Request $request)
    {
        $user = User::find($this->user->id);
        if ($user) {
            if ($request->notification) {
                $user->notification = 1;
                $user->save();
            } else {
                $user->notification = 0;
                $user->save();
            }
            $request->session()->put('Auth', $user);
        }
        return redirect('/setting');
    }

    public function getTestMail()
    {
        $user = User::find($this->user->id);
        try {
            if ($user) {
                Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
                    $m->from('admin@moneyflow.mrrkh.com', 'Money Flow Notification');
                    $m->to($user->email, $user->username)->subject('Your plan is going on, Go update it!');
                });
            }
            return "Success";
        } catch (Exception $e) {
            return "Failed";
        }
    }
}
