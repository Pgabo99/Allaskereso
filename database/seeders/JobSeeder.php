<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use MongoDB\BSON\ObjectId;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            ['_id' => '69d3ccffe0efd855180d0ec6', 'parent_job' => null, 'title' => 'Informatika'],
            ['_id' => '69d3cd0ee0efd855180d0ec7', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'Frontend fejlesztő'],
            ['_id' => '69d3cd12e0efd855180d0ec8', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'Backend fejlesztő'],
            ['_id' => '69d3cd1ae0efd855180d0ec9', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'Fullstack fejlesztő'],
            ['_id' => '69d3cd1fe0efd855180d0eca', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'Mobil alkalmazás fejlesztő'],
            ['_id' => '69d3cd23e0efd855180d0ecb', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'DevOps mérnök'],
            ['_id' => '69d3cd27e0efd855180d0ecc', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'QA / Tesztelő'],
            ['_id' => '69d3cd2ce0efd855180d0ecd', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'Rendszergazda'],
            ['_id' => '69d3cd36e0efd855180d0ece', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'IT support'],
            ['_id' => '69d3cd3ce0efd855180d0ecf', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'Adatmérnök (Data Engineer)'],
            ['_id' => '69d3cd43e0efd855180d0ed0', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'Data Scientist'],
            ['_id' => '69d3cd49e0efd855180d0ed1', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'AI / Machine Learning mérnök'],
            ['_id' => '69d3cd4ce0efd855180d0ed2', 'parent_job' => '69d3ccffe0efd855180d0ec6', 'title' => 'Cybersecurity szakember'],

            ['_id' => '69d3cdb5e0efd855180d0ed3', 'parent_job' => null, 'title' => 'Mérnöki / Műszaki'],
            ['_id' => '69d3cdbae0efd855180d0ed4', 'parent_job' => '69d3cdb5e0efd855180d0ed3', 'title' => 'Gépészmérnök'],
            ['_id' => '69d3cdbfe0efd855180d0ed5', 'parent_job' => '69d3cdb5e0efd855180d0ed3', 'title' => 'Villamosmérnök'],
            ['_id' => '69d3cdc4e0efd855180d0ed6', 'parent_job' => '69d3cdb5e0efd855180d0ed3', 'title' => 'Építőmérnök'],
            ['_id' => '69d3cdc8e0efd855180d0ed7', 'parent_job' => '69d3cdb5e0efd855180d0ed3', 'title' => 'Mechatronikai mérnök'],
            ['_id' => '69d3cdcde0efd855180d0ed8', 'parent_job' => '69d3cdb5e0efd855180d0ed3', 'title' => 'Karbantartó technikus'],
            ['_id' => '69d3cdd1e0efd855180d0ed9', 'parent_job' => '69d3cdb5e0efd855180d0ed3', 'title' => 'Gyártástechnológus'],

            ['_id' => '69d3cdd6e0efd855180d0eda', 'parent_job' => null, 'title' => 'Üzleti / Gazdasági'],
            ['_id' => '69d3cdd9e0efd855180d0edb', 'parent_job' => '69d3cdd6e0efd855180d0eda', 'title' => 'Könyvelő'],
            ['_id' => '69d3cddde0efd855180d0edc', 'parent_job' => '69d3cdd6e0efd855180d0eda', 'title' => 'Pénzügyi elemző'],
            ['_id' => '69d3cde1e0efd855180d0edd', 'parent_job' => '69d3cdd6e0efd855180d0eda', 'title' => 'HR munkatárs'],
            ['_id' => '69d3cde5e0efd855180d0ede', 'parent_job' => '69d3cdd6e0efd855180d0eda', 'title' => 'Toborzó (Recruiter)'],
            ['_id' => '69d3cde8e0efd855180d0edf', 'parent_job' => '69d3cdd6e0efd855180d0eda', 'title' => 'Projektmenedzser'],
            ['_id' => '69d3cdece0efd855180d0ee0', 'parent_job' => '69d3cdd6e0efd855180d0eda', 'title' => 'Üzletfejlesztő'],
            ['_id' => '69d3cdf0e0efd855180d0ee1', 'parent_job' => '69d3cdd6e0efd855180d0eda', 'title' => 'Ügyfélszolgálat'],

            ['_id' => '69d3cdf5e0efd855180d0ee2', 'parent_job' => null, 'title' => 'Marketing / Kreatív'],
            ['_id' => '69d3cdfae0efd855180d0ee3', 'parent_job' => '69d3cdf5e0efd855180d0ee2', 'title' => 'Marketing manager'],
            ['_id' => '69d3cdfee0efd855180d0ee4', 'parent_job' => '69d3cdf5e0efd855180d0ee2', 'title' => 'Social media manager'],
            ['_id' => '69d3ce02e0efd855180d0ee5', 'parent_job' => '69d3cdf5e0efd855180d0ee2', 'title' => 'Grafikus'],
            ['_id' => '69d3ce05e0efd855180d0ee6', 'parent_job' => '69d3cdf5e0efd855180d0ee2', 'title' => 'UI/UX designer'],
            ['_id' => '69d3ce08e0efd855180d0ee7', 'parent_job' => '69d3cdf5e0efd855180d0ee2', 'title' => 'Tartalomkészítő (Content creator)'],
            ['_id' => '69d3ce0de0efd855180d0ee8', 'parent_job' => '69d3cdf5e0efd855180d0ee2', 'title' => 'SEO szakember'],
            ['_id' => '69d3ce11e0efd855180d0ee9', 'parent_job' => '69d3cdf5e0efd855180d0ee2', 'title' => 'PPC szakértő'],

            ['_id' => '69d3ce16e0efd855180d0eea', 'parent_job' => null, 'title' => 'Kereskedelem / Értékesítés'],
            ['_id' => '69d3ce19e0efd855180d0eeb', 'parent_job' => '69d3ce16e0efd855180d0eea', 'title' => 'Értékesítő'],
            ['_id' => '69d3ce1ce0efd855180d0eec', 'parent_job' => '69d3ce16e0efd855180d0eea', 'title' => 'Bolti eladó'],
            ['_id' => '69d3ce20e0efd855180d0eed', 'parent_job' => '69d3ce16e0efd855180d0eea', 'title' => 'Területi képviselő'],
            ['_id' => '69d3ce24e0efd855180d0eee', 'parent_job' => '69d3ce16e0efd855180d0eea', 'title' => 'Key account manager'],

            ['_id' => '69d3ce2ce0efd855180d0eef', 'parent_job' => null, 'title' => 'Egészségügy'],
            ['_id' => '69d3ce30e0efd855180d0ef0', 'parent_job' => '69d3ce2ce0efd855180d0eef', 'title' => 'Orvos'],
            ['_id' => '69d3ce34e0efd855180d0ef1', 'parent_job' => '69d3ce2ce0efd855180d0eef', 'title' => 'Ápoló'],
            ['_id' => '69d3ce38e0efd855180d0ef2', 'parent_job' => '69d3ce2ce0efd855180d0eef', 'title' => 'Gyógyszerész'],
            ['_id' => '69d3ce3be0efd855180d0ef3', 'parent_job' => '69d3ce2ce0efd855180d0eef', 'title' => 'Asszisztens'],
            ['_id' => '69d3ce3fe0efd855180d0ef4', 'parent_job' => '69d3ce2ce0efd855180d0eef', 'title' => 'Gyógytornász'],

            ['_id' => '69d3ce43e0efd855180d0ef5', 'parent_job' => null, 'title' => 'Oktatás'],
            ['_id' => '69d3ce47e0efd855180d0ef6', 'parent_job' => '69d3ce43e0efd855180d0ef5', 'title' => 'Tanár'],
            ['_id' => '69d3ce4ae0efd855180d0ef7', 'parent_job' => '69d3ce43e0efd855180d0ef5', 'title' => 'Oktató'],
            ['_id' => '69d3ce4ee0efd855180d0ef8', 'parent_job' => '69d3ce43e0efd855180d0ef5', 'title' => 'Tréner'],
            ['_id' => '69d3ce52e0efd855180d0ef9', 'parent_job' => '69d3ce43e0efd855180d0ef5', 'title' => 'Mentor'],

            ['_id' => '69d3ce5ae0efd855180d0efa', 'parent_job' => null, 'title' => 'Logisztika / Szállítás'],
            ['_id' => '69d3ce5fe0efd855180d0efb', 'parent_job' => '69d3ce5ae0efd855180d0efa', 'title' => 'Sofőr'],
            ['_id' => '69d3ce62e0efd855180d0efc', 'parent_job' => '69d3ce5ae0efd855180d0efa', 'title' => 'Raktáros'],
            ['_id' => '69d3ce66e0efd855180d0efd', 'parent_job' => '69d3ce5ae0efd855180d0efa', 'title' => 'Logisztikai koordinátor'],
            ['_id' => '69d3ce69e0efd855180d0efe', 'parent_job' => '69d3ce5ae0efd855180d0efa', 'title' => 'Beszerző'],

            ['_id' => '69d3ce6ee0efd855180d0eff', 'parent_job' => null, 'title' => 'Fizikai / Szakmunkák'],
            ['_id' => '69d3ce72e0efd855180d0f00', 'parent_job' => '69d3ce6ee0efd855180d0eff', 'title' => 'Villanyszerelő'],
            ['_id' => '69d3ce77e0efd855180d0f01', 'parent_job' => '69d3ce6ee0efd855180d0eff', 'title' => 'Vízvezeték-szerelő'],
            ['_id' => '69d3ce7be0efd855180d0f02', 'parent_job' => '69d3ce6ee0efd855180d0eff', 'title' => 'Hegesztő'],
            ['_id' => '69d3ce7ee0efd855180d0f03', 'parent_job' => '69d3ce6ee0efd855180d0eff', 'title' => 'Asztalos'],
            ['_id' => '69d3ce82e0efd855180d0f04', 'parent_job' => '69d3ce6ee0efd855180d0eff', 'title' => 'Festő'],
        ];

        foreach ($jobs as $job) {
            Job::updateOrCreate(
                ['_id' => new ObjectId($job['_id'])],
                [
                    'parent_job' => $job['parent_job'],
                    'title' => $job['title'],
                ]
            );
        }
    }
}
