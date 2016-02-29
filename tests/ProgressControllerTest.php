<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Plan;
use App\Models\Monthly;

class ProgressControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public $user;
    public function setUp(){
        parent::setUp();
    }
    public function generateProgress($progress = 0){
        $user = new User();
        $user->username = "unitest";
        $user->email = "test@test.com";
        $user->password = "unitest";
        $user->save();

        $plan = new Plan();
        $plan->user_id = $user->id;
        $plan->name = 'UnitTestProject';
        $plan->description = 'UnitTestProject';
        $plan->budget = '0';
        $plan->target = '10000';
        $plan->expected = '1000';
        $plan->period = '10';
        $plan->created_at = date('Y-m-d H:i:s', strtotime('-1 month', strtotime(date('Y-m-d'))));
        $plan->updated_at = date('Y-m-d H:i:s', strtotime('-1 month', strtotime(date('Y-m-d'))));
        $plan->save();

        $month = new Monthly();
        $month->plan_id = $plan->id;
        $month->status = 0;
        $month->month = 1;
        $month->limit = 1000;
        $month->progress = $progress;
        $month->save();
        return ['plan' => $plan,'month' => $month,'user' => $user];
    }
    public function testProgreeOverLimit()
    {

        $obj = $this->generateProgress(1100);
        $this->withSession(['Auth' => $obj['user'] ])
        ->visit('/progress/?id='.$obj['plan']->id)
        ->see('Very good! you have succeed');

        $obj['user']->delete();
        $obj['plan']->delete();
        Monthly::where('plan_id','=',$obj['plan']->id)->delete();
    }
    public function testProgressLessThanLimit()
    {
        $obj = $this->generateProgress(900);
        $this->withSession(['Auth' => $obj['user'] ])
        ->visit('/progress/?id='.$obj['plan']->id)
        ->see('Too bad cannot reach you goal last month');

        $obj['user']->delete();
        $obj['plan']->delete();
        Monthly::where('plan_id','=',$obj['plan']->id)->delete();    
    }
    public function testProgressLessThanZero()
    {
        $obj = $this->generateProgress(-500);
        $this->withSession(['Auth' => $obj['user'] ])
        ->visit('/progress/?id='.$obj['plan']->id)
        ->see('Too bad you use');

        $obj['user']->delete();
        $obj['plan']->delete();
        Monthly::where('plan_id','=',$obj['plan']->id)->delete();    
    }
}