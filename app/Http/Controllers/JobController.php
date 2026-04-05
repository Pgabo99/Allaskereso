<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCreateRequest;
use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function create(JobCreateRequest $request): JsonResponse {
        $validated = $request->validated();
        $job = Job::firstOrCreate($validated);

        return response()->json(['success' => true, 'job' => $job]);
    }

    public function index(Request $request): Collection
    {
        $onlyMainJobs = $request->boolean('only_main_jobs');
        return Job::select('id', 'title')->when($onlyMainJobs, function ($query) {
            return $query->whereNull('parent_job');
        })->get();
    }
}
