<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<10;$i++){
            $category = new App\Category;
            $category->profile_id = 1;
            if($i <5){
                $category->type = 'income';
            }else{
                $category->type = 'expense';
            }
            $category->title = 'Category Title';
            $category->logo_id = 1;
            $category->save();  
        }
    }
}
