<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class simpleData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Default Category*/
        $category          = new Category();
        $category->user_id = 0;
        $category->name    = "Food & Drink";
        $category->save();

        $category          = new Category();
        $category->user_id = 0;
        $category->name    = "Bills";
        $category->save();

        $category          = new Category();
        $category->user_id = 0;
        $category->name    = "Transportation";
        $category->save();

        $category          = new Category();
        $category->user_id = 0;
        $category->name    = "Cellular";
        $category->save();

        $category          = new Category();
        $category->user_id = 0;
        $category->name    = "Tax";
        $category->save();
    }
}
