<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 50; $i++) {
            $data[] = [
                'user_id' => rand(2, 11), // 2〜11 のランダムな user_id
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'title' => 'Sample Inquiry ' . $i,
                'content' => 'This is a sample inquiry message number ' . $i . '.',
                'category' => ['Login Issues', 'Billing', 'Feature Request', 'Other'][array_rand(['Login Issues', 'Billing', 'Feature Request', 'Other'])],
                'memo' => 'This is a memo for inquiry ' . $i,
                'status' => ['pending', 'in_progress', 'completed'][array_rand(['pending', 'in_progress', 'completed'])],
                'created_at' => Carbon::now()->subDays(rand(1, 30)), // 過去 30 日以内のランダムな日付
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('inquiries')->insert($data);
    }
}
