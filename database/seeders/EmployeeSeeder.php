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

            // Employees for the 10 new companies
            // TechSphere Kft.
            ['user_id' => '6a000013e0efd855180d0013', 'company_id' => '69d3e480e0efd855180d0f18', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']], // Fekete Zoltán @ TechSphere
            ['user_id' => '6a000014e0efd855180d0014', 'company_id' => '69d3e480e0efd855180d0f18', 'rights' => ['HANDLE_APPLICATIONS']],                                           // Győri Annamária @ TechSphere

            // InnoVibe Kft.
            ['user_id' => '6a000015e0efd855180d0015', 'company_id' => '69d3e495e0efd855180d0f19', 'rights' => ['CREATE_JOB_OFFER', 'EDIT_COMPANY_DATA']],                         // Benedek Csaba @ InnoVibe
            ['user_id' => '6a000016e0efd855180d0016', 'company_id' => '69d3e495e0efd855180d0f19', 'rights' => ['HANDLE_APPLICATIONS']],                                           // Kertész Mónika @ InnoVibe

            // DigiCore Kft.
            ['user_id' => '6a000017e0efd855180d0017', 'company_id' => '69d3e4a8e0efd855180d0f1a', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']], // Hegedűs Roland @ DigiCore
            ['user_id' => '6a000018e0efd855180d0018', 'company_id' => '69d3e4a8e0efd855180d0f1a', 'rights' => ['CREATE_JOB_OFFER']],                                              // Szalai Judit @ DigiCore
            ['user_id' => '6a000019e0efd855180d0019', 'company_id' => '69d3e4a8e0efd855180d0f1a', 'rights' => ['HANDLE_APPLICATIONS']],                                           // Dobos Ákos @ DigiCore

            // ProLogic Kft.
            ['user_id' => '6a00001ae0efd855180d001a', 'company_id' => '69d3e4bbe0efd855180d0f1b', 'rights' => ['CREATE_JOB_OFFER', 'EDIT_COMPANY_DATA']],                         // Pintér Katalin @ ProLogic
            ['user_id' => '6a00001be0efd855180d001b', 'company_id' => '69d3e4bbe0efd855180d0f1b', 'rights' => ['HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']],                      // Somogyi Norbert @ ProLogic

            // SoftNest Kft.
            ['user_id' => '6a00001ce0efd855180d001c', 'company_id' => '69d3e4cee0efd855180d0f1c', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS']],                       // Fülöp Henrietta @ SoftNest
            ['user_id' => '6a00001de0efd855180d001d', 'company_id' => '69d3e4cee0efd855180d0f1c', 'rights' => ['EDIT_COMPANY_DATA']],                                             // Gál Tibor @ SoftNest

            // MindBridge Kft.
            ['user_id' => '6a00001ee0efd855180d001e', 'company_id' => '69d3e4e1e0efd855180d0f1d', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']], // Virág Melinda @ MindBridge
            ['user_id' => '6a00001fe0efd855180d001f', 'company_id' => '69d3e4e1e0efd855180d0f1d', 'rights' => ['CREATE_JOB_OFFER']],                                              // Hajdu Krisztián @ MindBridge
            ['user_id' => '6a000020e0efd855180d0020', 'company_id' => '69d3e4e1e0efd855180d0f1d', 'rights' => ['HANDLE_APPLICATIONS']],                                           // Németh Orsolya @ MindBridge

            // CodeCraft Kft.
            ['user_id' => '6a000021e0efd855180d0021', 'company_id' => '69d3e4f4e0efd855180d0f1e', 'rights' => ['CREATE_JOB_OFFER', 'EDIT_COMPANY_DATA']],                         // Bíró Attila @ CodeCraft
            ['user_id' => '6a000022e0efd855180d0022', 'company_id' => '69d3e4f4e0efd855180d0f1e', 'rights' => ['HANDLE_APPLICATIONS']],                                           // Szűcs Erzsébet @ CodeCraft

            // PrimeData Kft.
            ['user_id' => '6a000023e0efd855180d0023', 'company_id' => '69d3e507e0efd855180d0f1f', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']], // Dávid Mátyás @ PrimeData
            ['user_id' => '6a000024e0efd855180d0024', 'company_id' => '69d3e507e0efd855180d0f1f', 'rights' => ['CREATE_JOB_OFFER']],                                              // Fekete Kinga @ PrimeData
            ['user_id' => '6a000025e0efd855180d0025', 'company_id' => '69d3e507e0efd855180d0f1f', 'rights' => ['HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']],                      // Orosz Szilárd @ PrimeData

            // TurboSystems Kft.
            ['user_id' => '6a000026e0efd855180d0026', 'company_id' => '69d3e51ae0efd855180d0f20', 'rights' => ['CREATE_JOB_OFFER', 'EDIT_COMPANY_DATA']],                         // Vásárhelyi Tímea @ TurboSystems
            ['user_id' => '6a000027e0efd855180d0027', 'company_id' => '69d3e51ae0efd855180d0f20', 'rights' => ['HANDLE_APPLICATIONS']],                                           // Bárdos Mihály @ TurboSystems

            // HorizonTech Kft.
            ['user_id' => '6a000028e0efd855180d0028', 'company_id' => '69d3e52de0efd855180d0f21', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']], // Ladányi Noémi @ HorizonTech
            ['user_id' => '6a000029e0efd855180d0029', 'company_id' => '69d3e52de0efd855180d0f21', 'rights' => ['CREATE_JOB_OFFER']],                                              // Almási Zoltán @ HorizonTech
            ['user_id' => '6a00002ae0efd855180d002a', 'company_id' => '69d3e52de0efd855180d0f21', 'rights' => ['HANDLE_APPLICATIONS', 'EDIT_COMPANY_DATA']],                      // Csíki Beáta @ HorizonTech

            // A few cross-company relationships
            ['user_id' => '6a000013e0efd855180d0013', 'company_id' => '69d3e4f4e0efd855180d0f1e', 'rights' => ['HANDLE_APPLICATIONS']],                                           // Fekete Zoltán @ CodeCraft (also)
            ['user_id' => '6a000021e0efd855180d0021', 'company_id' => '69d3e52de0efd855180d0f21', 'rights' => ['CREATE_JOB_OFFER']],                                              // Bíró Attila @ HorizonTech (also)
            ['user_id' => '6a00001ee0efd855180d001e', 'company_id' => '69d3e4cee0efd855180d0f1c', 'rights' => ['CREATE_JOB_OFFER', 'HANDLE_APPLICATIONS']],                       // Virág Melinda @ SoftNest (also)
        ];

        foreach ($employees as $employee) {
            Employee::updateOrCreate(
                ['user_id' => $employee['user_id'], 'company_id' => $employee['company_id']],
                ['rights' => $employee['rights']]
            );
        }
    }
}
