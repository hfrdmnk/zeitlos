<?php

namespace Database\Seeders;

use App\Models\Entry;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $startDate = Carbon::now()->subYears(3);
        $endDate = Carbon::now();

        $existingDates = collect();

        $count = 0;
        $items = 300;
        $maxAttempts = $items * 10; // Prevent infinite loop
        $attempt = 0;

        while ($count < $items && $attempt < $maxAttempts) {
            $date = Carbon::instance(fake()->dateTimeBetween($startDate, $endDate))->format('Y-m-d');

            if (! $existingDates->contains($date)) {
                Entry::factory()->create([
                    'user_id' => $user->id,
                    'date' => $date,
                ]);
                $existingDates->push($date);
                $count++;
            }

            $attempt++;
        }

        if ($count < 100) {
            $this->command->info("Only created $count unique entries. Increase date range or decrease entry count.");
        }
    }
}
