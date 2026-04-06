<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index(): Collection
    {
        return Company::all();
    }

    public function employees(Company $company): Collection
    {
        return Employee::where('company_id', $company->id)->with('user')->get();
    }

    public function store(CompanyCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        $company = Company::create($data);

        return response()->json(['success' => true, 'company' => $company], 201);
    }
}
