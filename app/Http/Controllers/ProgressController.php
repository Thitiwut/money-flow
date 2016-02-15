<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Finance;
use App\Models\Monthly;
use DateTime;
use Illuminate\Http\Request;
use Session;

class ProgressController extends Controller
{
    public function getIndex(Request $request)
    {
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
                $month->month    = sizeof($plan->months());
                $month->limit    = ($plan->target - $plan->budget) / $plan->period;
                $month->progress = 0;
                $month->save();
            } else {
                $month = $plan->months()->orderBy('id', 'desc')->first();
                if ($month) {
                    $attach['progress'] = ($month->progress / $month->limit) * 100;
                }

            }
            $attach['plan']     = $plan;
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
            return view('progress.index')->with($attach);
        } else {
            return view('progress.index');
        }
    }
}
