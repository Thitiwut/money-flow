<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class HomeControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $this->visit('/register')
            ->type('test', 'username')
            ->type('test@test.com', 'email')
            ->type('123456', 'password')
            ->type('123456', 'repassword')
            ->press('Submit')
            ->seePageIs('/progress');
        $user = User::where("email","=","test@test.com")->first();
        $this->assertNotNull($user);
        $user->delete();
    }
}
