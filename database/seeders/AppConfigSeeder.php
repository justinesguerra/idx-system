<?php

namespace Database\Seeders;

use App\Models\AppConfig;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppConfig::truncate();

        $data = [
            ["label" => "API_USERNAME", "value" => "admin_uw5rki1o"],
            ["label" => "API_PASSWORD", "value" => "5KkoIO~uTI%1Coc4"],
            ["label" => "LISTINGS_URL", "value" => "https://homesandlifestyle.com/wp-json/wpl_api/v2/listings"],
            ["label" => "LEADS_URL", "value" => "https://homesandlifestyle.com/wp-json/wpl_api/v2/agents"],
            ["label" => "FAVORITES_URL", "value" => "https://homesandlifestyle.com/wp-json/wpl_api/v2/favorite-list"],
        ];

        AppConfig::insert($data);
    }
}
 