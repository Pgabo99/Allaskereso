<?php

namespace App\Http\Controllers;

use App\EmployeeRoleEnum;
use App\Http\Requests\CompanyAddEmployeeRequest;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyRegisterEmployeeRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index(): Collection
    {
        return Company::userCompanies()->get();
    }

    public function canCreateJobOffers(Company $company): JsonResponse
    {
        return response()->json($company->can_create_job_offers);
    }

    public function employees(Company $company): JsonResponse
    {
        $return['employees'] = Employee::where('company_id', $company->id)->with('user')->get();
        $return['canEditCompany'] = $company->can_edit_company;
        $return['ownerId'] = $company->created_by;

        return response()->json($return);
    }

    public function addEmployee(CompanyAddEmployeeRequest $request, Company $company): JsonResponse
    {
        $identifier = $request->validated()['identifier'];
        $rights = $request->validated()['rights'] ?? [];

        $user = User::where('email', $identifier)->orWhere('username', $identifier)->first();

        if (!$user) {
            return response()->json(['message' => 'A felhasználó nem található.'], 404);
        }

        $already = Employee::where('company_id', $company->id)->where('user_id', $user->id)->exists();

        if ($already) {
            return response()->json(['message' => 'A felhasználó már alkalmazott ebben a cégben.'], 422);
        }

        $employee = Employee::create([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'rights' => $rights,
        ]);

        return response()->json(['success' => true, 'employee' => $employee->load('user')], 201);
    }

    public function registerEmployee(CompanyRegisterEmployeeRequest $request, Company $company): JsonResponse
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birth_date' => $data['birth_date'],
        ]);

        $employee = Employee::create([
            'company_id' => $company->id,
            'user_id' => $user->id,
            'rights' => $data['rights'] ?? [],
        ]);

        return response()->json(['success' => true, 'employee' => $employee->load('user')], 201);
    }

    public function updateEmployee(Company $company, Employee $employee): JsonResponse
    {
        $rights = request()->validate([
            'rights' => 'array',
            'rights.*' => 'string|in:CREATE_JOB_OFFER,HANDLE_APPLICATIONS,EDIT_COMPANY_DATA',
        ])['rights'] ?? [];

        $employee->update(['rights' => $rights]);

        return response()->json(['success' => true, 'employee' => $employee->load('user')]);
    }

    public function removeEmployee(Company $company, Employee $employee): JsonResponse
    {
        $employee->delete();

        return response()->json(['success' => true]);
    }

    public function update(CompanyCreateRequest $request, Company $company): JsonResponse
    {
        $company->update($request->validated());

        return response()->json(['success' => true, 'company' => $company]);
    }

    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json(['success' => true]);
    }

    public function store(CompanyCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id();

        $company = Company::create($data);
        Employee::create([
           'company_id' => $company->getKey(),
            'user_id' => Auth::id(),
            'rights' => array_column(EmployeeRoleEnum::cases(), 'value'),
        ]);

        return response()->json(['success' => true, 'company' => $company], 201);
    }
}
