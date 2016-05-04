<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Year;
use App\Make;
use App\YearMake;
use App\Model;
use App\Review;
use App\Category;
use App\Style;
use App\ModelCategory;
use App\ModelStyle;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserTableSeeder::class);
        // $this->call(YearTableSeeder::class);
        // $this->call(CategoryTableSeeder::class);
        // $this->call(StyleTableSeeder::class);

        //$this->call(FakeSeeder::class);
    }
}

// class ModelUpdater extends Seeder {

//     public function run() {
//         // Add img url column
//         Schema::table('models', function($table)
//         {
//             $table->string('img_url');
//         });
//     }
// }


class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);
    }

}

class YearTableSeeder extends Seeder {

    public function run()
    {
        DB::table('years')->delete();

        Year::create([
            'number' => 2016
        ]);

        // Year::create([
        //     'number' => 2015
        // ]);
        // Year::create([
        //     'number' => 2014
        // ]);
        // Year::create([
        //     'number' => 2013
        // ]);
        // Year::create([
        //     'number' => 2012
        // ]);
        // Year::create([
        //     'number' => 2011
        // ]);
        // Year::create([
        //     'number' => 2010
        // ]);
        // Year::create([
        //     'number' => 2009
        // ]);
        // Year::create([
        //     'number' => 2008
        // ]);
        // Year::create([
        //     'number' => 2007
        // ]);
    }

}

class CategoryTableSeeder extends Seeder {

    public function run()
    {
        DB::table('categories')->delete();

        Category::create([
            'name' => 'subcompact'
        ]);
        Category::create([
            'name' => 'compact'
        ]);
        Category::create([
            'name' => 'mid-size'
        ]);
        Category::create([
            'name' => 'full-size'
        ]);
        Category::create([
            'name' => 'sport'
        ]);
        Category::create([
            'name' => 'gas'
        ]);
        Category::create([
            'name' => 'hybrid/electric'
        ]);
        Category::create([
            'name' => 'diesel'
        ]);
        Category::create([
            'name' => 'luxury'
        ]);
        Category::create([
            'name' => 'premium'
        ]);
        Category::create([
            'name' => 'supercar'
        ]);
        Category::create([
            'name' => 'exotic'
        ]);
        Category::create([
            'name' => 'economy'
        ]);
    }
}

class StyleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('styles')->delete();

        Style::create([
            'name' => 'sedan'
        ]);
        Style::create([
            'name' => 'coupe'
        ]);
        Style::create([
            'name' => 'convertible'
        ]);
        Style::create([
            'name' => 'suv/crossover'
        ]);
        Style::create([
            'name' => 'truck'
        ]);
        Style::create([
            'name' => 'van/minivan'
        ]);
        Style::create([
            'name' => 'wagon'
        ]);
        Style::create([
            'name' => 'hatchback'
        ]);
    }

}

// Generate fake Makes, Models, Categories, and Reviews for Testing
class FakeSeeder extends Seeder {

    public function run()
    {
        DB::table('models_categories')->delete();
        DB::table('models_styles')->delete();
        DB::table('reviews')->delete();
        DB::table('models')->delete();
        DB::table('years_makes')->delete();
        DB::table('makes')->delete();

        $faker = Faker\Factory::create();

        // Generate 50 fake makes
        $maxMakes = 50;

        for ($i=0; $i < $maxMakes; $i++) {
            Make::create([
                'name' => ucfirst($faker->unique()->word)
            ]);
        }

        $years = Year::all();
        $makes = Make::all();

        // Generate a make-year relation for each year and make
        foreach ($years as $year) {
            foreach ($makes as $make) {
                YearMake::firstOrCreate(array('year_id' => $year->id, 'make_id' => $make->id));
            }
        }

        // Generate fake models
        foreach ($makes as $make) {
            $yearMakes = YearMake::where('make_id', $make->id)->get();

            foreach ($yearMakes as $yearMake) {

                $modelLimit = 8;

                for ($i=0; $i < $modelLimit; $i++) {

                    Model::create([
                        'year_make_id' => $yearMake->id,
                        'name' => ucfirst($faker->word),
                        'gen' => rand (1, 11)
                    ]);
                }
            }
        }

        // Generate fake reviews
        $models = Model::all();

        foreach ($models as $model) {

            $reviewLimit = 15;

            for ($i=0; $i < $reviewLimit; $i++) {

                Review::create([
                    'model_id' => $model->id,
                    'rating' => $this->frand(0, 5, 1),
                    'by' => $faker->name,
                    'url' => $faker->url,
                    'excerpt' => $faker->text($maxNbChars = 499)
                ]);
            }
        }

        $categories = Category::all();
        $styles = Style::all();

        foreach ($models as $model) {

            $categoryLimit = 4;

            $usedCategories = array();
            $usedStyles = array();

            for ($i=0; $i < $categoryLimit; $i++) {

                $catIndex = rand (0, count($categories) - 1);
                $styleIndex = rand (0, count($styles) - 1);

                if (!in_array($categories[$catIndex], $usedCategories)) {
                    array_push($usedCategories, $categories[$catIndex]);
                    ModelCategory::create([
                        'model_id' => $model->id,
                        'category_id' => $categories[$catIndex]->id
                    ]);
                }

                if (!in_array($styles[$styleIndex], $usedStyles)) {
                    array_push($usedStyles, $styles[$styleIndex]);
                    ModelStyle::create([
                        'model_id' => $model->id,
                        'style_id' => $styles[$styleIndex]->id
                    ]);
                }

            }
        }

    }

    function frand($min, $max, $decimals = 0) {
      $scale = pow(10, $decimals);
      return mt_rand($min * $scale, $max * $scale) / $scale;
    }

}
