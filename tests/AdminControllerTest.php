<?php
use App\Models\Admin;
class AdminControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->visit('/admin')
            ->see('LOGIN');
    }
    public function testUsers()
    {
        $this->withSession(['Admin' => new Admin()])
            ->visit('/admin/users')
            ->see('Username');
    }
    public function testFeedbacks()
    {
        $this->withSession(['Admin' => new Admin()])
            ->visit('/admin/feedbacks')
            ->see('Feedback');
    }
    public function testBanners()
    {
        $this->withSession(['Admin' => new Admin()])
            ->visit('/admin/banners')
            ->see('BANNERS');
    }
    public function testLogout()
    {
        $this->visit('/admin/logout')
            ->see('STUDENT MONEY ASSISTANCE');
    }
}
