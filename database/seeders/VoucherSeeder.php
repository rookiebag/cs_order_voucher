<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Voucher;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 10) as $index) {
            $monthStart = Carbon::now()->startOfMonth();
            $todayDate = Carbon::now()->format('d');
            $month = Carbon::now()->format('m');
            $lastDate = Carbon::now()->month($month)->daysInMonth;
            DB::table('vouchers')->insert([
                'name' => Str::random(100),
                'code' => Str::random(10),
                'type' => rand(1, 2),
                'discount_value' => rand(1, 10),
                'is_valid' => 1,
                'start_date' => $monthStart->addDays(rand(1, $todayDate))->format('Y-m-d H:i:s'),
                'end_date' => $monthStart->addDays(rand($todayDate, $lastDate))->format('Y-m-d H:i:s'),
            ]);
        }

        foreach (range(1, 10) as $index) {
            $monthStart = Carbon::now()->startOfMonth();
            $todayDate = Carbon::now()->format('d');
            $month = Carbon::now()->format('m');
            $lastDate = Carbon::now()->month($month)->daysInMonth;
            DB::table('vouchers')->insert([
                'name' => Str::random(100),
                'code' => Str::random(10),
                'type' => rand(1, 2),
                'discount_value' => rand(1, 10),
                'is_valid' => 1,
                'start_date' => $monthStart->addDays(rand(1, $todayDate))->format('Y-m-d H:i:s'),
                'end_date' => $monthStart->addDays(rand($todayDate - 5, $lastDate))->format('Y-m-d H:i:s'),
            ]);
        }
    }
}