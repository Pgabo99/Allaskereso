<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobOfferCreateRequest;
use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class JobOfferController extends Controller
{
    public function index(): Collection
    {
        return JobOffer::all();
    }

    public function show(JobOffer $jobOffer): JsonResponse
    {
        return response()->json($jobOffer);
    }

    public function store(JobOfferCreateRequest $request): JsonResponse
    {
        $jobOffer = JobOffer::create($request->validated());

        return response()->json(['success' => true, 'job_offer' => $jobOffer], 201);
    }
}
