<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationCreateRequest;
use App\Models\Application;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(): Collection
    {
        return Application::with('jobOffer.company')
            ->where('user_id', Auth::id())
            ->get();
    }

    public function forJobOffer(JobOffer $jobOffer): JsonResponse
    {
        if (!$jobOffer->company?->can_handle_applications) {
            abort(403);
        }

        $applications = Application::where('job_offer_id', $jobOffer->id)->get();

        $userIds = $applications->pluck('user_id')->unique();
        $users = User::whereIn('_id', $userIds)->get()->keyBy('_id');

        $data = $applications->map(function ($application) use ($users) {
            $user = $users->get($application->user_id);
            return [
                'id'         => $application->id,
                'status'     => $application->status,
                'cv_url'     => Storage::url($application->cv),
                'applicant'  => $user ? [
                    'name'       => $user->name,
                    'email'      => $user->email,
                    'birth_date' => $user->birth_date,
                ] : null,
            ];
        });

        return response()->json($data);
    }

    public function updateStatus(Application $application): JsonResponse
    {
        $jobOffer = JobOffer::find($application->job_offer_id);

        if (!$jobOffer?->company?->can_handle_applications) {
            abort(403);
        }

        $status = request()->validate([
            'status' => 'required|in:APPROVED,DECLINED',
        ])['status'];

        $application->update(['status' => $status]);

        return response()->json(['success' => true, 'status' => $application->status]);
    }

    public function store(ApplicationCreateRequest $request): JsonResponse
    {
        $path = $request->file('cv')->store('cvs', 'public');

        $application = Application::create([
            'user_id'      => Auth::id(),
            'job_offer_id' => $request->validated('job_offer_id'),
            'cv'           => $path,
            'status'       => 'PENDING',
        ]);

        return response()->json(['success' => true, 'application_id' => $application->id], 201);
    }

    public function destroy(Application $application): JsonResponse
    {
        if ($application->user_id !== Auth::id() || $application->status !== 'PENDING') {
            abort(403);
        }

        $application->delete();

        return response()->json(['success' => true]);
    }
}
