<?php
use App\Models\User;
class ExpenseControllerTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->withSession(['Auth' => new User()])
            ->visit('/expense')
            ->see('EXPENSE AND INCOME');
    }
}
