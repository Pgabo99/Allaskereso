<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use MongoDB\BSON\ObjectId;


class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            ['_id' => '69d3e338e0efd855180d0f06', 'name' => 'PixelForge Kft.', 'contact_email' => 'info@pixelforge.hu', 'location' => '6722 Szeged, Kossuth Lajos sgt. 45.', 'tax_id' => '28765432-2-06', 'created_by' => '6a000009e0efd855180d0009'],
            ['_id' => '69d3e349e0efd855180d0f07', 'name' => 'GreenLeaf Solutions Kft.', 'contact_email' => 'kapcsolat@greenleaf.hu', 'location' => '1117 Budapest, Fehérvári út 120.', 'tax_id' => '14567893-2-43', 'created_by' => '6a000009e0efd855180d0009'],
            ['_id' => '69d3e35be0efd855180d0f08', 'name' => 'BlueWave Technologies Kft.', 'contact_email' => 'hello@bluewave.hu', 'location' => '4025 Debrecen, Piac utca 18.', 'tax_id' => '19876543-2-09', 'created_by' => '6a000009e0efd855180d0009'],
            ['_id' => '69d3e36be0efd855180d0f09', 'name' => 'SmartCore Systems Kft.', 'contact_email' => 'support@smartcore.hu', 'location' => '7621 Pécs, Rákóczi út 12.', 'tax_id' => '17654329-2-02', 'created_by' => '6a000009e0efd855180d0009'],
            ['_id' => '69d3e37de0efd855180d0f0a', 'name' => 'NovaBuild Kft.', 'contact_email' => 'iroda@novabuild.hu', 'location' => '9022 Győr, Szent István út 99.', 'tax_id' => '23456789-2-08', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e39be0efd855180d0f0b', 'name' => 'CodeNest Kft.', 'contact_email' => 'contact@codenest.hu', 'location' => '6724 Szeged, Vértó utca 8.', 'tax_id' => '25678901-2-06', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e3aae0efd855180d0f0c', 'name' => 'SkyNet Solutions Kft.', 'contact_email' => 'info@skynet.hu', 'location' => '1138 Budapest, Váci út 144.', 'tax_id' => '26789012-2-41', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e3b9e0efd855180d0f0d', 'name' => 'DataBridge Kft.', 'contact_email' => 'office@databridge.hu', 'location' => '3530 Miskolc, Széchenyi utca 56.', 'tax_id' => '27890123-2-05', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e3c9e0efd855180d0f0e', 'name' => 'AlphaByte Kft.', 'contact_email' => 'info@alphabyte.hu', 'location' => '6000 Kecskemét, Nagykőrösi utca 21.', 'tax_id' => '28901234-2-03', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e3dae0efd855180d0f0f', 'name' => 'CloudPeak Kft.', 'contact_email' => 'hello@cloudpeak.hu', 'location' => '9700 Szombathely, Fő tér 7.', 'tax_id' => '29012345-2-18', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e3f8e0efd855180d0f10', 'name' => 'IronGate Solutions Kft.', 'contact_email' => 'support@irongate.hu', 'location' => '8000 Székesfehérvár, Palotai út 15.', 'tax_id' => '30123456-2-07', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e405e0efd855180d0f11', 'name' => 'BrightMind Kft.', 'contact_email' => 'info@brightmind.hu', 'location' => '7400 Kaposvár, Ady Endre utca 10.', 'tax_id' => '31234567-2-14', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e415e0efd855180d0f12', 'name' => 'WebCore Studio Kft.', 'contact_email' => 'contact@webcore.hu', 'location' => '6720 Szeged, Dugonics tér 2.', 'tax_id' => '32345678-2-06', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e422e0efd855180d0f13', 'name' => 'FutureStack Kft.', 'contact_email' => 'hello@futurestack.hu', 'location' => '1095 Budapest, Soroksári út 30.', 'tax_id' => '33456789-2-43', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e434e0efd855180d0f14', 'name' => 'NetFusion Kft.', 'contact_email' => 'info@netfusion.hu', 'location' => '4400 Nyíregyháza, Dózsa György út 5.', 'tax_id' => '34567890-2-15', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e44be0efd855180d0f15', 'name' => 'QuantumSoft Kft.', 'contact_email' => 'office@quantumsoft.hu', 'location' => '8200 Veszprém, Kossuth utca 33.', 'tax_id' => '35678901-2-19', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e458e0efd855180d0f16', 'name' => 'LogicLane Kft.', 'contact_email' => 'contact@logiclane.hu', 'location' => '5600 Békéscsaba, Andrássy út 44.', 'tax_id' => '36789012-2-04', 'created_by' => '6a000001e0efd855180d0013'],
            ['_id' => '69d3e466e0efd855180d0f17', 'name' => 'DevHive Kft.', 'contact_email' => 'info@devhive.hu', 'location' => '6726 Szeged, Fő fasor 12.', 'tax_id' => '37890123-2-06', 'created_by' => '6a000001e0efd855180d0013'],
        ];

        foreach ($companies as $company) {
            Company::updateOrCreate(
                ['_id' => new ObjectId($company['_id'])],
                [
                    'name' => $company['name'],
                    'contact_email' => $company['contact_email'],
                    'location' => $company['location'],
                    'tax_id' => $company['tax_id'],
                    'created_by' => $company['created_by'],
                ]
            );
        }
    }
}
