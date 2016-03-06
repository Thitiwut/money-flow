<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plan;
use App\Models\Restrict;
use Illuminate\Http\Request;
use Session;
use Validator;

class PlanController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /*Get Methods*/
    public function getIndex(Request $request)
    {
        $attach['categories'] = Category::where("user_id", "=", "0")->get();
        $attach['user']       = $this->user;
        if (isset($request->id)) {
            $attach['plan'] = $this->user->plans()->where('id', '=', $request->id)->first();
        } else if (Session::has('Plan')) {
            $attach['plan'] = $this->user->plans()->where('id', '=', Session::get('Plan'))->first();
        }

        return view('plan.create')->with($attach);
    }

    public function getClear(Request $request)
    {
        Session::forget('Plan');
        return redirect()->back();
    }

    public function getDelete(Request $request)
    {
        if ($this->user != null && Session::has('Plan')) {
            $plan      = Plan::find(Session::get('Plan'));
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
            Session::put('successes',["Plan is deleted!"]);
        }
        Session::forget('Plan');
        return redirect('plan');
    }
    /*Post Method*/
    public function postIndex(Request $request)
    {
        $messages = [
            "pname.required"        => "Plan name is required",
            "pdescription.required" => "Description is required",
            "pexpected.required"    => "Expected per month is required",
            "ptarget.required"      => "Target for saving is required",
            "pbudget.required"      => "Budget is required",
            "pmonth.required"      => "Period is required",

            "pname.alpha_num"       => "Plan name must be consist of texts and numbers",
            "pexpected.numeric"     => "Expected per month must be consist of only numbers",
            "ptarget.numeric"       => "Target for saving must be consist of only numbers",
            "pbudget.numeric"       => "Budget must be consist of only numbers",
            "pmonth.numeric"       => "Period must be consist of only numbers",
        ];
        $validator = Validator::make($request->all(), [
            'pname'        => 'required|alpha_num',
            'pdescription' => 'required',
            'pexpected'    => 'required|numeric',
            'ptarget'      => 'required|numeric',
            'pbudget'      => 'required|numeric',
            'pmonth'        => 'required|numeric|min:1',
        ], $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->pdelete != null) {
            return redirect('plan/delete');
        }

        if ($request->pbudget > $request->ptarget) {
            $validator->errors()->add('target', 'Budget is more than target!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->pexpected >= $request->ptarget) {
            $validator->errors()->add('target', 'Expected per month is more than target!');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!$this->user) {
            $validator->errors()->add('user', 'You are not login!');
            return redirect('login')->withErrors($validator);
        } else {
            $plan = $this->user->plans()->where("id", "=", $request->plan_id)->first();
            if (!$plan) {
                $plan = new Plan();
                $plan->budget      = $request->pbudget;
            }
            //$period            = ceil(($request->ptarget - $request->pbudget) / $request->pexpected);
            $plan->user_id     = $this->user->id;
            $plan->name        = $request->pname;
            $plan->description = $request->pdescription;
            $plan->period      = $request->pmonth;
            $plan->target      = $request->ptarget;
            $plan->expected    = $request->pexpected;
            $plan->original    = $request->pbudget;
            $plan->save();
            Session::put("Plan", $plan->id);
        }
        return redirect()->back()->withInput();
    }
    public function postCategory(Request $request)
    {
        $messages = [
            "cname.required" => "Category name is required",
        ];
        $validator = Validator::make($request->all(), [
            'cname' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($this->user == null) {
            $validator->errors()->add('User', 'You are not login!');
            return redirect('login')->withErrors($validator);
        } else {
            $category          = new Category();
            $category->user_id = $this->user->id;
            $category->name    = $request->cname;
            $category->save();
        }
        return redirect()->back()->withInput();
    }
    public function postRestrict(Request $request)
    {
        $messages = [
            "rplan.required"     => "Plan is not select please go to your managing panel.",
            "rplan.exists"       => "Plan is not exists.",
            "rplan.numeric"      => "Illegal plan access.",
            "rcategory.required" => "Category is not selected.",
            "rcategory.exists"   => "Category is not exists.",
            "rcategory.numeric"  => "Illegal category selected.",
            "rlimit.required"    => "Exceed is required.",
            "rlimit.numeric"     => "Exceed should be only numbers.",
            "rtype.required"     => "Please select what this restriction apply to.",
            "rtype.boolean"      => "Illegal restriction type selected.",
        ];
        $validator = Validator::make($request->all(), [
            'rplan'     => 'required|numeric|exists:plan,id',
            'rcategory' => 'required|numeric|exists:category,id',
            'rlimit'    => 'required|numeric',
            'rtype'     => 'required|boolean',
        ], $messages);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($this->user == null) {
            $validator->errors()->add('User', 'You are not login!');
            return redirect('login')->withErrors($validator);
        } else {
            $restrict              = new Restrict();
            $restrict->plan_id     = $request->rplan;
            $restrict->category_id = $request->rcategory;
            $restrict->exceed      = $request->rlimit;
            $restrict->for         = $request->rtype;
            $restrict->save();
        }
        return redirect()->back()->withInput();
    }
    public function postDeleteRestrict(Request $request)
    {
        if ($request->restrict != null) {
            foreach ($request->restrict as $key => $value) {
                Restrict::find($value)->delete();
            }
        }
        return redirect()->back()->withInput();
    }
}
