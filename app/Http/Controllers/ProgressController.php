<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Finance;
use App\Models\Monthly;
use DateTime;
use Illuminate\Http\Request;
use Session;
use Validator;

class ProgressController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getIndex(Request $request)
    {
        $successes = array();
        $validator = Validator::make($request->all(), []);
        if (isset($request->id)) {
            $plan = $this->user->plans()->where('id', '=', $request->id)->first();
        } else if (Session::has('Plan')) {
            $plan = $this->user->plans()->where('id', '=', Session::get('Plan'))->first();
        }
        if (isset($plan)) {
            $now    = new DateTime(date('m/d/Y'));
            $create = new DateTime($plan->created_at);
            // $create   = new DateTime('2016-11-14');
            $interval = $now->diff($create);

            $diff = $interval->format('%m');
            if (sizeof($plan->months()->get()) <= $diff && $diff <= $plan->period || $diff == 0 && sizeof($plan->months()) <= $diff) {
                $month           = new Monthly();
                $month->plan_id  = $plan->id;
                $month->status   = 0;
                $month->month    = sizeof($plan->months) + 1;
                $month->limit    = $plan->expected;
                $month->progress = 0;

                $monthLeft = $plan->period - $diff;
                if ($monthLeft > 0) {
                    $newExpected = ceil(($plan->target - $plan->budget) / $monthLeft);
                } else {
                    $newExpected = 1;
                }

                $lastMonth = $plan->months()->orderBy('id', 'desc')->first();
                if ($lastMonth) {
                    if ($lastMonth->progress != $lastMonth->limit) {
                        $month->limit = $newExpected;
                        if ($lastMonth->progress > $lastMonth->limit) {
                            $successes[] = "Very good! you have succeed " . ($lastMonth->progress - $lastMonth->limit) . " more than limit!";
                        } else if ($lastMonth->progress < $lastMonth->limit && $lastMonth->progress >= 0) {
                            $validator->errors()->add('User', 'Too bad cannot reach you goal last month! anyway, keep doing!');
                        } else if ($lastMonth->progress < $lastMonth->limit && $lastMonth->progress < 0) {
                            $validator->errors()->add('User', 'Too bad you use ' . $lastMonth->progress . ' more than limit last month!!');
                        }
                    }

                }
                $month->save();
                $attach['progress'] = ($month->progress / $month->limit) * 100;
            } else {
                $month = $plan->months()->orderBy('id', 'desc')->first();
                if ($month) {
                    if ($month->limit == 0) {
                        $month->limit = 1;
                    }

                    $attach['progress'] = ($month->progress / $month->limit) * 100;
                }

            }
            $attach['plan']     = $plan;
            $attach['month']    = $month;
            $attach['category'] = [];
            $categories         = Category::where('user_id', '=', $this->user->id)->orWhere('user_id', '=', 0)->get();
            $start              = date('Y-m-d', strtotime('+' . $month->month - 1 . ' month', strtotime($plan->created_at)));
            $end                = date('Y-m-d', strtotime('+' . $month->month . ' month', strtotime($plan->created_at)));
            foreach ($categories as $category) {
                $sumIncome = Finance::join('category', 'category.id', '=', 'finance.category_id')
                    ->join('daily', 'daily.id', '=', 'finance.daily_id')
                    ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                    ->where('monthly.id', '=', $month->id)
                    ->where('finance.category_id', '=', $category->id)
                    ->where('type', '=', 1)
                    ->where('daily.date', '>=', $start)
                    ->where('daily.date', '<=', $end)
                    ->sum('amount');
                $sumExpense = Finance::join('category', 'category.id', '=', 'finance.category_id')
                    ->join('daily', 'daily.id', '=', 'finance.daily_id')
                    ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                    ->where('monthly.id', '=', $month->id)
                    ->where('finance.category_id', '=', $category->id)
                    ->where('type', '=', 0)
                    ->where('daily.date', '>=', $start)
                    ->where('daily.date', '<=', $end)
                    ->sum('amount');
                if ($sumIncome > 0 || $sumExpense > 0) {
                    $attach['category'][] = [
                        "name" => $category->name
                        , "income" => $sumIncome
                        , "expense" => $sumExpense];
                }
            }
            if ($plan->budget >= $plan->target) {
                $successes[] = "Congratuation! You have reach your goal!!!";
            } else if ($diff >= $plan->period && $plan->budget < $plan->target) {
                $validator->errors()->add('User', 'This plan has been fail!! Please try again with more discipline!');
            }
            Session::forget('successes');
            Session::put('successes', $successes);
            return view('progress.index')->with($attach)->withErrors($validator);
        } else {
            return view('progress.index');
        }
    }
}
