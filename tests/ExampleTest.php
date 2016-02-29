<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
    	$this->visit('/login')
    	->see('Login');
    }
    public function testLoginIWithOutEmail()
    {
    	$this->visit('/login')
    	->type('a@a.com', 'email')
    	->press('Login')
    	->seePageIs('/login');
    }
    public function testLoginIWithEmail()
    {
    	$this->visit('/login')
    	->type('a@a.com', 'email')
    	->type('123456', 'password')
    	->press('Login')
    	->seePageIs('/progress');
    }
		// public function testRegisterWithUsername()
  //   {
  //         $this->visit('/register')
		// 	 ->type('t@t.com', 'email')
		// 	 ->press('Submit')
		// 	 ->seePageIs('/register');
  //   }
		// public function testRegisterWithFull()
  //   {
  //         $this->visit('/register')
		// 	 ->type('aa', 'username')
		// 	 ->type('aa@a.com', 'email')
		// 	 ->type('123456', 'password')
		// 	 ->type('123456', 'repassword')
		// 	 ->press('Submit')
		// 	 ->seePageIs('/progress');
  //   }
		// public function testCreatePlanrWithoutSth()
		// {
		// 	  $this->visit('/plan')
		// 		 ->type('aa', 'pname')
		// 		 ->type('description', 'pdescription')
		// 		 ->type('123456', 'pbudget')
		// 		 ->type('1', 'pmonth')
		// 		 ->press('Save')
		// 		 ->seePageIs('/plan');
		// }
}
