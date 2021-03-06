<?php

use App\Models\Plan;
use App\Models\User;

class PlanControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }
    public function generateUser()
    {
        $user           = new User();
        $user->username = "unitest";
        $user->email    = "test@test.com";
        $user->password = "unitest";
        $user->save();
        return $user;
    }
    public function testIndex()
    {
        $this->withSession(['Auth' => new User()])
            ->visit('/plan')
            ->see('PLAN');
    }
    public function testCreate()
    {
        $user = $this->generateUser();
        $this->visit('/plan')
            ->withSession(['Auth' => $user])
            ->type('UnitTestProject', 'pname')
            ->type('Test', 'pdescription')
            ->type('1000', 'pexpected')
            ->type('10000', 'ptarget')
            ->type('0', 'pbudget')
            ->type('10', 'pmonth')
            ->press('pSave')
            ->seePageIs('/plan');
        $plan = Plan::where("name", "=", "UnitTestProject")->first();
        $this->assertNotNull($plan);
        $plan->delete();
        $user->delete();
    }
}
