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
                $category->logo_id = 1;
            }else{
                $category->type = 'expense';
                $category->logo_id = 2;
            }
            $category->title = 'Category Title';
            $category->save();  
        }
    }
}
