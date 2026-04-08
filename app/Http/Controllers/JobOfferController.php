<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobOfferCreateRequest;
use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function index(Request $request): Collection
    {
        $query = JobOffer::with('company');

        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        return $query->get();
    }

    public function show(JobOffer $jobOffer): JsonResponse
    {
        return response()->json($jobOffer->load('company'));
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
