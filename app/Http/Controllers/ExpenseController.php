<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Daily;
use App\Models\Finance;
use App\Models\Monthly;
use App\Models\Plan;
use App\Models\Restrict;
use DateTime;
use Illuminate\Http\Request;
use Session;
use Validator;

class ExpenseController extends Controller
{
    /*Get Methods*/
    public function getIndex()
    {
        $attach['categories'] = Category::where("user_id", "=", "0")->get();
        $attach['user']       = $this->user;
        if (isset($request->id)) {
            $attach['plan'] = $this->user->plans()->where('id', '=', $request->id)->first();
        } else if (Session::has('Plan')) {
            $attach['plan'] = Plan::find(Session::get('Plan'));
        }

        if (isset($attach['plan'])) {
            if ($month = $attach['plan']->months()->orderBy('id', 'desc')->first()) {
                $attach['daily'] = $month->days()
                    ->where('date', '>=', date('Y-m-d'))
                    ->where('date', '<=', date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d')))))
                    ->first();
            }
        }
        return view('expense.create')->with($attach);
    }

    /*Post Methods*/
    public function postFinance(Request $request)
    {
        $successes = array();
        $messages  = [
            "plan_id.required"   => "Plan is not selected.",
            "fcategory.required" => "Please select category.",
            "fname.required"     => "Please specify the name of this transaction.",
            "famount.required"   => "Please insert the amount.",
            "ftype.required"     => "Is it expense or income?",

            "plan_id.numeric"    => "Plan is select illegally.",
            "fcategory.numeric"  => "Category is select illegally.",
            "famount.numeric"    => "Amount can be only numeric.",
            "ftype.boolean"      => "Type is illegally injected.",

            "plan_id.exists"     => "Plan is not exist within system.",
            "fcategory.exists"   => "Category is not exist within system.",
        ];

        $validator = Validator::make($request->all(), [
            'plan_id'   => 'required|numeric|exists:plan,id',
            'fcategory' => 'required|numeric|exists:category,id',
            'fname'     => 'required',
            'famount'   => 'required|numeric',
            'ftype'     => 'required|boolean',
        ], $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!Session::has('Plan')) {
            $validator->errors()->add('User', 'Please select plan!');
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($this->user == null) {
            $validator->errors()->add('User', 'You are not login!');
            return redirect('login')->withErrors($validator);
        } else {

            $plan   = Plan::find(Session::get('Plan'));
            $now    = new DateTime(date('Y-m-d'));
            $create = new DateTime($plan->created_at);
            // $create   = new DateTime('2016-11-14');
            $interval = $now->diff($create);

            $diff = $interval->format('%m');
            if (sizeof($plan->months()->get()) <= $diff && $diff <= $plan->period || $diff == 0 && sizeof($plan->months()) <= $diff) {
                $month           = new Monthly();
                $month->plan_id  = Session::get('Plan');
                $month->status   = 0;
                $month->month    = sizeof($plan->months()) + 1;
                $month->limit    = $plan->expected;
                $month->progress = 0;

                $newExpected = ceil(($plan->target - $plan->budget) / ($plan->period - $diff));
                $lastMonth   = $plan->months()->orderBy('id', 'desc')->first();
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
            } else {
                $month = $plan->months()->orderBy('id', 'desc')->first();
            }
            $date  = str_replace('/', '-', $request->fdate);
            $daily = $month->days()->where('date', '>=', date('Y-m-d', strtotime($date)))
                ->where('date', '<=', date('Y-m-d', strtotime('+1 day', strtotime($date))))
                ->first();

            if ($daily == null) {

                $daily             = new Daily();
                $daily->monthly_id = $month->id;
                $daily->date       = date('Y-m-d', strtotime($date));
                $daily->expense    = 0;
                $daily->income     = 0;
            }

            $sumExpenseDaily = Finance::join('category', 'category.id', '=', 'finance.category_id')
                ->join('daily', 'daily.id', '=', 'finance.daily_id')
                ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                ->where('monthly.id', '=', $month->id)
                ->where('finance.category_id', '=', $request->fcategory)
                ->where('type', '=', 0)
                ->where('daily.id', '=', $daily->id)
                ->sum('amount');
            $sumExpenseMonthly = Finance::join('category', 'category.id', '=', 'finance.category_id')
                ->join('daily', 'daily.id', '=', 'finance.daily_id')
                ->join('monthly', 'monthly.id', '=', 'daily.monthly_id')
                ->where('monthly.id', '=', $month->id)
                ->where('finance.category_id', '=', $request->fcategory)
                ->where('type', '=', 0)
                ->sum('amount');
            $restrictDaily   = Restrict::where('plan_id', '=', $plan->id)->where('category_id', '=', $request->fcategory)->where('for', '=', 0)->first();
            $restrictMonthly = Restrict::where('plan_id', '=', $plan->id)->where('category_id', '=', $request->fcategory)->where('for', '=', 1)->first();
            if ($restrictDaily) {
                $sumExpenseDaily += $request->famount;
                if ($restrictDaily->exceed < $sumExpenseDaily) {
                    $validator->errors()->add('User', 'Exceed per day!');
                    //return redirect()->back()->withInput()->withErrors($validator);
                }
            }
            if ($restrictMonthly) {
                $sumExpenseMonthly += $request->famount;
                if ($restrictMonthly->exceed < $sumExpenseMonthly) {
                    $validator->errors()->add('User', 'Exceed per month!');
                    //return redirect()->back()->withInput()->withErrors($validator);
                }
            }
            if ($request->ftype == 0) {
                $daily->expense += $request->famount;
                $month->progress = $month->progress - $request->famount;
                $plan->budget -= $request->famount;
            } else {
                $daily->income += $request->famount;
                $month->progress = $month->progress + $request->famount;
                $plan->budget += $request->famount;
            }
            $daily->save();

            $finance              = new Finance();
            $finance->daily_id    = $daily->id;
            $finance->category_id = $request->fcategory;
            $finance->description = $request->fdescription;
            $finance->name        = $request->fname;
            $finance->amount      = $request->famount;
            $finance->type        = $request->ftype;

            $plan->save();
            if ($plan->budget >= $plan->target) {
                $successes[] = "Congratuation! You have reach your goal!!!";
            }else if($diff >= $plan->period && $plan->budget < $plan->target){
                $validator->errors()->add('User', 'This plan has been fail!! Please try again with more discipline!');
            }
            Session::forget('successes');
            Session::put('successes', $successes);
            $finance->save();
            $month->save();
        }
        return redirect()->back()->withInput()->withErrors($validator);
    }
    public function postDelete(Request $request)
    {
        if ($request->expense != null) {
            foreach ($request->expense as $key => $value) {
                $finance = Finance::find($value);
                if ($finance->type == 0) {

                    $day = Daily::find($finance->daily_id);
                    $day->expense -= $finance->amount;
                    $day->save();

                    $month = Monthly::find($day->monthly_id);
                    $month->progress += $finance->amount;
                    $month->save();

                    $plan = Plan::find($month->plan_id);
                    $plan->budget += $finance->amount;
                    $plan->save();
                } else {
                    $day = Daily::find($finance->daily_id);
                    $day->income -= $finance->amount;
                    $day->save();

                    $month = Monthly::find($day->monthly_id);
                    $month->progress -= $finance->amount;
                    $month->save();

                    $plan = Plan::find($month->plan_id);
                    $plan->budget -= $finance->amount;
                    $plan->save();
                }
                $finance->delete();
                Session::forget("successes");
                Session::put("successes", ["Delete expense successes fully."]);
            }
        } else {
            Session::forget("successes");
            Session::put("successes", ["No item selected!"]);
        }
        return redirect()->back()->withInput();
    }
}
