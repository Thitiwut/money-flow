<?php

use App\Models\User;

class HomeControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->visit('/')
            ->see('STUDENT MONEY ASSISTANCE');
    }
    public function testLogin()
    {
        $this->visit('/login')
            ->see('LOGIN');
    }
    public function testRegister()
    {
        $this->visit('/register')
            ->type('test', 'username')
            ->type('test@test.com', 'email')
            ->type('123456', 'password')
            ->type('123456', 'repassword')
            ->press('Submit')
            ->seePageIs('/progress');
        $user = User::where("email", "=", "test@test.com")->first();
        $this->assertNotNull($user);
        $user->delete();
    }
    public function testList()
    {
        $this->withSession(['Auth' => new User()])
            ->visit('/list')
            ->see('CHECK-LIST');
    }
    public function testSetting()
    {
        $this->withSession(['Auth' => new User()])
            ->visit('/setting')
            ->see('SETTING');
    }
    public function testLogout()
    {
        $this->visit('/logout')
            ->see('STUDENT MONEY ASSISTANCE');
    }
    public function testFeedback()
    {
        $this->visit('/feedback')
            ->see('FEEDBACK');
    }
    public function test()
    {
        $this->visit('/register')
            ->see('register');
    }
}
