<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCreateRequest;
use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function create(JobCreateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $job = Job::firstOrCreate($validated);

        return response()->json(['success' => true, 'job' => $job]);
    }

    public function index(): Collection
    {
        return Job::whereNull('parent_job')->with('children')->get();
    }

    public function update(Request $request, Job $job): JsonResponse
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $job->update($validated);

        return response()->json(['success' => true, 'job' => $job]);
    }

    public function destroy(Job $job): JsonResponse
    {
        $job->delete();

        return response()->json(['success' => true]);
    }
}
