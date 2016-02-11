<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plan;
use Illuminate\Http\Request;
use Validator;

class PlanController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /*Get Methods*/
    public function getIndex()
    {
        return view('plan.create');
    }

    /*Post Method*/
    public function postPlan()
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|alpha_num',
            'description' => 'required|alpha_num',
            'capital'     => 'required|numeric',
        ]);

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
            $plan              = new Plan();
            $plan->user_id     = $this->user->id;
            $plan->name        = $request->name;
            $plan->description = $request->name;
            $plan->capital     = $request->name;
            $plan->save();
        }
        return redirect()->back()->withInput();
    }
    public function postCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

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
            $category->name    = $request->name;
            $category->save();
        }
        return redirect()->back()->withInput();
    }
    public function postRestrict()
    {
        $validator = Validator::make($request->all(), [
            'plan_id'     => 'required|exists:plan,id',
            'category_id' => 'required|numeric|exists:category,id',
            'exceed'      => 'required|numeric',
            'for'         => 'required|boolean',
        ]);

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
            $restrict->plan_id     = $request->plan_id;
            $restrict->category_id = $request->category_id;
            $restrict->exceed      = $request->exceed;
            $restrict->for      = $request->for;
            $restrict->save();
        }
        return redirect()->back()->withInput();
    }
}
