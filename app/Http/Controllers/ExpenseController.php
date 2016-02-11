<?php
namespace App\Http\Controllers;

use App\Models\Finance;

class ExpenseController extends Controller
{
    /*Get Methods*/
    public function getIndex()
    {
        return view('expense.create');
    }

    /*Post Methods*/
    public function postDaily()
    {
        $validator = Validator::make($request->all(), [
            'daily_id'    => 'required|exists:daily,id',
            'category_id' => 'required|numeric|exists:category,id',
            'description' => 'required|alpah_num',
            'name'        => 'required|alpah_num',
            'amount'      => 'required|numeric',
            'type'        => 'required|boolean',
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
            $finance              = new Finance();
            $finance->daily_id    = $request->daily_id;
            $finance->category_id = $request->category_id;
            $finance->description = $request->description;
            $finance->name        = $request->name;
            $finance->amount      = $request->amount;
            $finance->type        = $request->type;
            $finance->save();
        }
        return redirect()->back()->withInput();
    }
    public function postFinance()
    {
        $validator = Validator::make($request->all(), [
            'daily_id'    => 'required|exists:daily,id',
            'category_id' => 'required|numeric|exists:category,id',
            'description' => 'required|alpah_num',
            'name'        => 'required|alpah_num',
            'amount'      => 'required|numeric',
            'type'        => 'required|boolean',
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
            $daily = Daily::find($request->daily_id);
            if ($daily == null) {
                $validator->errors()->add('User', 'You are not login!');
                return redirect()->back()->withInput();
            }
            $finance              = new Finance();
            $finance->daily_id    = $request->daily_id;
            $finance->category_id = $request->category_id;
            $finance->description = $request->description;
            $finance->name        = $request->name;
            $finance->amount      = $request->amount;
            $finance->type        = $request->type;
            try {
            	if($finance->type == 0){
            		$daily->expense += $finance->amount;
            	}else if($finance->type == 1){
            		$daily->income += $finance->amount;
            	}
                $finance->save();
                $daily->save();
            } catch (Exception $e) {

            }

        }
        return redirect()->back()->withInput();
    }
}
