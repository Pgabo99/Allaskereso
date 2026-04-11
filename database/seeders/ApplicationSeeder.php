<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\JobOffer;
use Illuminate\Database\Seeder;
use App\Models\User;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $jobOffers = JobOffer::pluck('id');
        $users = User::pluck('id');
        $status = collect(['PENDING', 'APPROVED', 'DECLINED']);

        for ($i = 0; $i < 50; $i++) {
            Application::updateOrCreate(
                ['user_id' => $users->random(), 'job_offer_id' => $jobOffers->random()],
                [
                    'cv' => 'cvs/dummy_cv.pdf',
                    'status' => $status->random(),
                ]
            );
        }
    }
}
