<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use Illuminate\Database\Seeder;

class JobOfferSeeder extends Seeder
{
    public function run(): void
    {
        $jobOffers = [
            [
                'title' => 'Junior Frontend Developer',
                'description' => 'Modern webalkalmazások fejlesztése React és TypeScript használatával.',
                'salary_min' => 450000,
                'salary_max' => 650000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd0ee0efd855180d0ec7',
                'company_id' => '69d3e338e0efd855180d0f06',
            ],
            [
                'title' => 'Backend PHP Developer',
                'description' => 'Laravel alapú rendszerek fejlesztése és karbantartása.',
                'salary_min' => 500000,
                'salary_max' => 800000,
                'location' => 'Szeged',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cd12e0efd855180d0ec8',
                'company_id' => '69d3e39be0efd855180d0f0b',
            ],
            [
                'title' => 'Full Stack Developer',
                'description' => 'Frontend és backend fejlesztési feladatok ellátása modern technológiákkal.',
                'salary_min' => 600000,
                'salary_max' => 1000000,
                'location' => 'Debrecen',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd1ae0efd855180d0ec9',
                'company_id' => '69d3e35be0efd855180d0f08',
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => 'CI/CD pipeline-ok kialakítása és felhő infrastruktúra kezelése.',
                'salary_min' => 700000,
                'salary_max' => 1200000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd23e0efd855180d0ecb',
                'company_id' => '69d3e3aae0efd855180d0f0c',
            ],
            [
                'title' => 'QA Engineer',
                'description' => 'Automatizált és manuális tesztelés végrehajtása.',
                'salary_min' => 400000,
                'salary_max' => 650000,
                'location' => 'Győr',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd27e0efd855180d0ecc',
                'company_id' => '69d3e37de0efd855180d0f0a',
            ],
            [
                'title' => 'Mobile App Developer',
                'description' => 'iOS és Android alkalmazások fejlesztése Flutter vagy React Native használatával.',
                'salary_min' => 550000,
                'salary_max' => 900000,
                'location' => 'Pécs',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd1fe0efd855180d0eca',
                'company_id' => '69d3e36be0efd855180d0f09',
            ],
            [
                'title' => 'Data Analyst',
                'description' => 'Adatok elemzése és riportok készítése üzleti döntések támogatására.',
                'salary_min' => 500000,
                'salary_max' => 750000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd43e0efd855180d0ed0',    // Data Scientist
                'company_id' => '69d3e3b9e0efd855180d0f0d', // DataBridge Kft.
            ],
            [
                'title' => 'UI/UX Designer',
                'description' => 'Felhasználóbarát felületek tervezése és prototípusok készítése.',
                'salary_min' => 450000,
                'salary_max' => 700000,
                'location' => 'Szeged',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3ce05e0efd855180d0ee6',    // UI/UX designer
                'company_id' => '69d3e415e0efd855180d0f12', // WebCore Studio Kft.
            ],
            [
                'title' => 'System Administrator',
                'description' => 'Szerverek és hálózati rendszerek üzemeltetése.',
                'salary_min' => 500000,
                'salary_max' => 800000,
                'location' => 'Miskolc',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cd2ce0efd855180d0ecd',    // Rendszergazda
                'company_id' => '69d3e3f8e0efd855180d0f10', // IronGate Solutions Kft.
            ],
            [
                'title' => 'Cloud Engineer',
                'description' => 'AWS vagy Azure alapú rendszerek tervezése és karbantartása.',
                'salary_min' => 750000,
                'salary_max' => 1300000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd23e0efd855180d0ecb',    // DevOps mérnök
                'company_id' => '69d3e3dae0efd855180d0f0f', // CloudPeak Kft.
            ],
            [
                'title' => 'AI Engineer',
                'description' => 'Gépi tanulási modellek fejlesztése és integrálása.',
                'salary_min' => 800000,
                'salary_max' => 1400000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd49e0efd855180d0ed1',    // AI / Machine Learning mérnök
                'company_id' => '69d3e422e0efd855180d0f13', // FutureStack Kft.
            ],
            [
                'title' => 'Cybersecurity Specialist',
                'description' => 'Rendszerek biztonságának felügyelete és sebezhetőségek kezelése.',
                'salary_min' => 700000,
                'salary_max' => 1200000,
                'location' => 'Debrecen',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cd4ce0efd855180d0ed2',    // Cybersecurity szakember
                'company_id' => '69d3e3f8e0efd855180d0f10', // IronGate Solutions Kft.
            ],
            [
                'title' => 'Business Analyst',
                'description' => 'Üzleti folyamatok elemzése és optimalizálása.',
                'salary_min' => 500000,
                'salary_max' => 850000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cdece0efd855180d0ee0',    // Üzletfejlesztő
                'company_id' => '69d3e349e0efd855180d0f07', // GreenLeaf Solutions Kft.
            ],
            [
                'title' => 'Java Developer',
                'description' => 'Nagyvállalati alkalmazások fejlesztése Java és Spring használatával.',
                'salary_min' => 650000,
                'salary_max' => 1100000,
                'location' => 'Szeged',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cd12e0efd855180d0ec8',    // Backend fejlesztő
                'company_id' => '69d3e466e0efd855180d0f17', // DevHive Kft.
            ],
            [
                'title' => 'Game Developer',
                'description' => 'Játékok fejlesztése Unity vagy Unreal Engine használatával.',
                'salary_min' => 500000,
                'salary_max' => 900000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd1ae0efd855180d0ec9',    // Fullstack fejlesztő
                'company_id' => '69d3e44be0efd855180d0f15', // QuantumSoft Kft.
            ],
            [
                'title' => 'Product Manager',
                'description' => 'Termékfejlesztési folyamatok koordinálása és stratégia kialakítása.',
                'salary_min' => 800000,
                'salary_max' => 1300000,
                'location' => 'Budapest',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cde8e0efd855180d0edf',    // Projektmenedzser
                'company_id' => '69d3e422e0efd855180d0f13', // FutureStack Kft.
            ],
            [
                'title' => 'Technical Support Engineer',
                'description' => 'Ügyféltámogatás és technikai problémák megoldása.',
                'salary_min' => 400000,
                'salary_max' => 600000,
                'location' => 'Szeged',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cd36e0efd855180d0ece',    // IT support
                'company_id' => '69d3e458e0efd855180d0f16', // LogicLane Kft.
            ],
            [
                'title' => 'Database Administrator',
                'description' => 'Adatbázisok kezelése, optimalizálása és karbantartása.',
                'salary_min' => 650000,
                'salary_max' => 1000000,
                'location' => 'Budapest',
                'work_mode' => 'REMOTE',
                'job_id' => '69d3cd3ce0efd855180d0ecf',    // Adatmérnök (Data Engineer)
                'company_id' => '69d3e3b9e0efd855180d0f0d', // DataBridge Kft.
            ],
            [
                'title' => 'Scrum Master',
                'description' => 'Agilis csapatok támogatása és folyamatok facilitálása.',
                'salary_min' => 700000,
                'salary_max' => 1100000,
                'location' => 'Debrecen',
                'work_mode' => 'HYBRID',
                'job_id' => '69d3cde8e0efd855180d0edf',    // Projektmenedzser
                'company_id' => '69d3e35be0efd855180d0f08', // BlueWave Technologies Kft.
            ],
            [
                'title' => 'Embedded Systems Engineer',
                'description' => 'Beágyazott rendszerek fejlesztése és tesztelése.',
                'salary_min' => 600000,
                'salary_max' => 1000000,
                'location' => 'Győr',
                'work_mode' => 'ON_SITE',
                'job_id' => '69d3cdc8e0efd855180d0ed7',    // Mechatronikai mérnök
                'company_id' => '69d3e37de0efd855180d0f0a', // NovaBuild Kft.
            ],
        ];

        foreach ($jobOffers as $offer) {
            JobOffer::updateOrCreate(
                ['title' => $offer['title']],
                $offer
            );
        }
    }
}
