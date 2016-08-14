<?php
use App\Models\User;
class ReportControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->withSession(['Auth' => new User()])
            ->visit('/report')
            ->see('REPORT');
    }
}
