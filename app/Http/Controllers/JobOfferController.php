<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobOfferCreateRequest;
use App\Models\Application;
use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOfferController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = JobOffer::with('company');

        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $offers = $query->get();

        $offerIds = $offers->pluck('id');

        $applications = Application::where('user_id', Auth::id())
            ->whereIn('job_offer_id', $offerIds)
            ->get()
            ->keyBy('job_offer_id');

        $applicationCounts = Application::whereIn('job_offer_id', $offerIds)
            ->get()
            ->groupBy('job_offer_id')
            ->map->count();

        $offers = $offers->map(function ($offer) use ($applications, $applicationCounts) {
            $application = $applications->get($offer->id);
            return array_merge($offer->toArray(), [
                'application_id'     => $application?->id,
                'application_status' => $application?->status,
                'applications_count' => $applicationCounts->get($offer->id, 0),
            ]);
        });

        return response()->json($offers);
    }

    public function show(JobOffer $jobOffer): JsonResponse
    {
        $jobOffer->load('company');

        $application = Application::where('user_id', Auth::id())
            ->where('job_offer_id', $jobOffer->id)
            ->first();

        return response()->json(array_merge($jobOffer->toArray(), [
            'application_id'          => $application?->id,
            'application_status'      => $application?->status,
            'can_handle_applications' => $jobOffer->company?->can_handle_applications ?? false,
        ]));
    }

    public function store(JobOfferCreateRequest $request): JsonResponse
    {
        $jobOffer = JobOffer::create($request->validated());

        return response()->json(['success' => true, 'job_offer' => $jobOffer], 201);
    }

    public function update(JobOfferCreateRequest $request, JobOffer $jobOffer): JsonResponse
    {
        $jobOffer->update($request->validated());

        return response()->json(['success' => true, 'job_offer' => $jobOffer]);
    }

    public function destroy(JobOffer $jobOffer): JsonResponse
    {
        $jobOffer->delete();

        return response()->json(['success' => true]);
    }
}
