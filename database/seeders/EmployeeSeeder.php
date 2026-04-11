<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            // Single-company employees
            ['user_id' => '6a000001e0efd855180d0001', 'company_id' => '69d3e338e0efd855180d0f06', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS']],           // Kiss Ádám @ PixelForge
            ['user_id' => '6a000002e0efd855180d0002', 'company_id' => '69d3e349e0efd855180d0f07', 'rights' => ['EDIT_COMPANY_DATA']],                                   // Nagy Dóra @ GreenLeaf
            ['user_id' => '6a000003e0efd855180d0003', 'company_id' => '69d3e35be0efd855180d0f08', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']], // Szabó Bence @ BlueWave
            ['user_id' => '6a000004e0efd855180d0004', 'company_id' => '69d3e36be0efd855180d0f09', 'rights' => ['HANDLE_APPLICATIONS']],                                  // Tóth Petra @ SmartCore
            ['user_id' => '6a000005e0efd855180d0005', 'company_id' => '69d3e37de0efd855180d0f0a', 'rights' => ['CREATE_JOB_OFFER']],                                     // Varga Gábor @ NovaBuild
            ['user_id' => '6a000006e0efd855180d0006', 'company_id' => '69d3e39be0efd855180d0f0b', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS']],              // Kovács Réka @ CodeNest
            ['user_id' => '6a000007e0efd855180d0007', 'company_id' => '69d3e3aae0efd855180d0f0c', 'rights' => ['CREATE_JOB_OFFER', 'EDIT_COMPANY_DATA']],                // Horváth Márk @ SkyNet
            ['user_id' => '6a000008e0efd855180d0008', 'company_id' => '69d3e3b9e0efd855180d0f0d', 'rights' => ['HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']],             // Farkas Zsófia @ DataBridge
            ['user_id' => '6a000009e0efd855180d0009', 'company_id' => '69d3e338e0efd855180d0f06', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']], // Molnár Dávid @ PixelForge
            ['user_id' => '6a00000ae0efd855180d000a', 'company_id' => '69d3e3c9e0efd855180d0f0e', 'rights' => ['CREATE_JOB_OFFER']],                                     // Balogh Anna @ AlphaByte
            ['user_id' => '6a00000be0efd855180d000b', 'company_id' => '69d3e3dae0efd855180d0f0f', 'rights' => ['HANDLE_APPLICATIONS']],                                  // Papp Levente @ CloudPeak
            ['user_id' => '6a00000ce0efd855180d000c', 'company_id' => '69d3e3f8e0efd855180d0f10', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']], // Lakatos Eszter @ IronGate
            ['user_id' => '6a00000de0efd855180d000d', 'company_id' => '69d3e405e0efd855180d0f11', 'rights' => ['EDIT_COMPANY_DATA']],                                    // Oláh Tamás @ BrightMind
            ['user_id' => '6a00000ee0efd855180d000e', 'company_id' => '69d3e415e0efd855180d0f12', 'rights' => ['CREATE_JOB_OFFER']],                                     // Simon Nóra @ WebCore Studio
            ['user_id' => '6a00000fe0efd855180d000f', 'company_id' => '69d3e422e0efd855180d0f13', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS']],              // Juhász Péter @ FutureStack
            ['user_id' => '6a000010e0efd855180d0010', 'company_id' => '69d3e434e0efd855180d0f14', 'rights' => ['HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']],             // Mészáros Lilla @ NetFusion
            ['user_id' => '6a000011e0efd855180d0011', 'company_id' => '69d3e44be0efd855180d0f15', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']], // Takács Bálint @ QuantumSoft
            ['user_id' => '6a000012e0efd855180d0012', 'company_id' => '69d3e458e0efd855180d0f16', 'rights' => ['CREATE_JOB_OFFER']],                                     // Kiss Viktória @ LogicLane

            // Multi-company employees (same user, different company)
            ['user_id' => '6a000001e0efd855180d0001', 'company_id' => '69d3e466e0efd855180d0f17', 'rights' => ['HANDLE_APPLICATIONS']],                                  // Kiss Ádám @ DevHive
            ['user_id' => '6a000003e0efd855180d0003', 'company_id' => '69d3e3aae0efd855180d0f0c', 'rights' => ['CREATE_JOB_OFFER']],                                     // Szabó Bence @ SkyNet
            ['user_id' => '6a000005e0efd855180d0005', 'company_id' => '69d3e3c9e0efd855180d0f0e', 'rights' => ['HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']],             // Varga Gábor @ AlphaByte
            ['user_id' => '6a000007e0efd855180d0007', 'company_id' => '69d3e349e0efd855180d0f07', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS']],              // Horváth Márk @ GreenLeaf
            ['user_id' => '6a000009e0efd855180d0009', 'company_id' => '69d3e3b9e0efd855180d0f0d', 'rights' => ['HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']],             // Molnár Dávid @ DataBridge
            ['user_id' => '6a00000be0efd855180d000b', 'company_id' => '69d3e422e0efd855180d0f13', 'rights' => ['EDIT_COMPANY_DATA']],                                    // Papp Levente @ FutureStack
            ['user_id' => '6a00000fe0efd855180d000f', 'company_id' => '69d3e466e0efd855180d0f17', 'rights' => ['CREATE_JOB_OFFER', 'EDIT_COMPANY_DATA']],                // Juhász Péter @ DevHive
        ];

        foreach ($employees as $employee) {
            Employee::updateOrCreate(
                ['user_id' => $employee['user_id'], 'company_id' => $employee['company_id']],
                ['rights' => $employee['rights']]
            );
        }
    }
}
