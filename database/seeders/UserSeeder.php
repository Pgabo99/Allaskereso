<?php

namespace Database\Seeders;

use App\Models\User;
use App\UserRoleEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use MongoDB\BSON\ObjectId;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['_id' => '6a000001e0efd855180d0001', 'name' => 'Kiss Ádám', 'username' => 'kissadam', 'email' => 'kiss.adam@gmail.com', 'password' => 'Adam123!', 'birth_date' => '1995-04-12', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000002e0efd855180d0002', 'name' => 'Nagy Dóra', 'username' => 'nagydora', 'email' => 'dora.nagy@gmail.com', 'password' => 'Dora2020!', 'birth_date' => '1998-07-23', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000003e0efd855180d0003', 'name' => 'Szabó Bence', 'username' => 'szabobence', 'email' => 'bence.szabo@gmail.com', 'password' => 'Bence!234', 'birth_date' => '1993-11-05', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000004e0efd855180d0004', 'name' => 'Tóth Petra', 'username' => 'tothpetra', 'email' => 'petra.toth@gmail.com', 'password' => 'Petra123!', 'birth_date' => '1997-02-14', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000005e0efd855180d0005', 'name' => 'Varga Gábor', 'username' => 'vargagabor', 'email' => 'gabor.varga@gmail.com', 'password' => 'Gabor2022!', 'birth_date' => '1990-09-30', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000006e0efd855180d0006', 'name' => 'Kovács Réka', 'username' => 'kovacsreka', 'email' => 'reka.kovacs@gmail.com', 'password' => 'Reka!456', 'birth_date' => '1996-06-18', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000007e0efd855180d0007', 'name' => 'Horváth Márk', 'username' => 'horvathmark', 'email' => 'mark.horvath@gmail.com', 'password' => 'Mark123!', 'birth_date' => '1994-01-27', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000008e0efd855180d0008', 'name' => 'Farkas Zsófia', 'username' => 'farkaszsofia', 'email' => 'zsofia.farkas@gmail.com', 'password' => 'Zsofia2021!', 'birth_date' => '1999-03-09', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000009e0efd855180d0009', 'name' => 'Molnár Dávid', 'username' => 'molnardavid', 'email' => 'david.molnar@gmail.com', 'password' => 'David!789', 'birth_date' => '1992-08-11', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00000ae0efd855180d000a', 'name' => 'Balogh Anna', 'username' => 'baloghanna', 'email' => 'anna.balogh@gmail.com', 'password' => 'Anna123!', 'birth_date' => '2000-12-01', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00000be0efd855180d000b', 'name' => 'Papp Levente', 'username' => 'papplevente', 'email' => 'levente.papp@gmail.com', 'password' => 'Levente2023!', 'birth_date' => '1991-05-16', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00000ce0efd855180d000c', 'name' => 'Lakatos Eszter', 'username' => 'lakatoseszter', 'email' => 'eszter.lakatos@gmail.com', 'password' => 'Eszter!321', 'birth_date' => '1997-10-22', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00000de0efd855180d000d', 'name' => 'Oláh Tamás', 'username' => 'olahtamas', 'email' => 'tamas.olah@gmail.com', 'password' => 'Tamas123!', 'birth_date' => '1989-07-04', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00000ee0efd855180d000e', 'name' => 'Simon Nóra', 'username' => 'simonnora', 'email' => 'nora.simon@gmail.com', 'password' => 'Nora2022!', 'birth_date' => '1998-04-28', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00000fe0efd855180d000f', 'name' => 'Juhász Péter', 'username' => 'juhaszpeter', 'email' => 'peter.juhasz@gmail.com', 'password' => 'Peter!654', 'birth_date' => '1993-09-12', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000010e0efd855180d0010', 'name' => 'Mészáros Lilla', 'username' => 'meszaroslilla', 'email' => 'lilla.meszaros@gmail.com', 'password' => 'Lilla123!', 'birth_date' => '1996-11-19', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000011e0efd855180d0011', 'name' => 'Takács Bálint', 'username' => 'takacsbalint', 'email' => 'balint.takacs@gmail.com', 'password' => 'Balint2020!', 'birth_date' => '1992-02-06', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000012e0efd855180d0012', 'name' => 'Kiss Viktória', 'username' => 'kissviktoria', 'email' => 'viktoria.kiss@gmail.com', 'password' => 'Viki!987', 'birth_date' => '1999-06-25', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000001e0efd855180d0013', 'name' => 'Admin Admin', 'username' => 'admin', 'email' => 'admin@gmail.com', 'password' => 'almafa123', 'birth_date' => '1995-04-12', 'role' => UserRoleEnum::ADMIN],
            ['_id' => '6a000013e0efd855180d0013', 'name' => 'Fekete Zoltán', 'username' => 'feketezoltan', 'email' => 'fekete.zoltan@gmail.com', 'password' => 'Zoltan123!', 'birth_date' => '1990-03-15', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000014e0efd855180d0014', 'name' => 'Győri Annamária', 'username' => 'gyoriannamaria', 'email' => 'gyori.annamaria@gmail.com', 'password' => 'Anna2024!', 'birth_date' => '1995-08-22', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000015e0efd855180d0015', 'name' => 'Benedek Csaba', 'username' => 'benedekcsaba', 'email' => 'benedek.csaba@gmail.com', 'password' => 'Csaba!456', 'birth_date' => '1988-11-07', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000016e0efd855180d0016', 'name' => 'Kertész Mónika', 'username' => 'kerteszmonika', 'email' => 'kertesz.monika@gmail.com', 'password' => 'Monika789!', 'birth_date' => '1997-05-30', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000017e0efd855180d0017', 'name' => 'Hegedűs Roland', 'username' => 'hegedusroland', 'email' => 'hegedus.roland@gmail.com', 'password' => 'Roland2022!', 'birth_date' => '1993-01-19', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000018e0efd855180d0018', 'name' => 'Szalai Judit', 'username' => 'szalaijudit', 'email' => 'szalai.judit@gmail.com', 'password' => 'Judit!321', 'birth_date' => '1999-07-04', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000019e0efd855180d0019', 'name' => 'Dobos Ákos', 'username' => 'dobosakos', 'email' => 'dobos.akos@gmail.com', 'password' => 'Akos2023!', 'birth_date' => '1994-09-13', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00001ae0efd855180d001a', 'name' => 'Pintér Katalin', 'username' => 'pinterkatalin', 'email' => 'pinter.katalin@gmail.com', 'password' => 'Katalin!12', 'birth_date' => '1991-04-26', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00001be0efd855180d001b', 'name' => 'Somogyi Norbert', 'username' => 'somogyinorbert', 'email' => 'somogyi.norbert@gmail.com', 'password' => 'Norbert123!', 'birth_date' => '1986-12-08', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00001ce0efd855180d001c', 'name' => 'Fülöp Henrietta', 'username' => 'fulophenrietta', 'email' => 'fulop.henrietta@gmail.com', 'password' => 'Henri!999', 'birth_date' => '1998-02-14', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00001de0efd855180d001d', 'name' => 'Gál Tibor', 'username' => 'galtibor', 'email' => 'gal.tibor@gmail.com', 'password' => 'Tibor2021!', 'birth_date' => '1985-06-20', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00001ee0efd855180d001e', 'name' => 'Virág Melinda', 'username' => 'viragmelinda', 'email' => 'virag.melinda@gmail.com', 'password' => 'Melinda!77', 'birth_date' => '2000-10-03', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00001fe0efd855180d001f', 'name' => 'Hajdu Krisztián', 'username' => 'hajdukrisztian', 'email' => 'hajdu.krisztian@gmail.com', 'password' => 'Krisz123!', 'birth_date' => '1992-03-17', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000020e0efd855180d0020', 'name' => 'Németh Orsolya', 'username' => 'nemethorsolya', 'email' => 'nemeth.orsolya@gmail.com', 'password' => 'Orsolya!45', 'birth_date' => '1996-08-29', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000021e0efd855180d0021', 'name' => 'Bíró Attila', 'username' => 'biroattila', 'email' => 'biro.attila@gmail.com', 'password' => 'Attila2020!', 'birth_date' => '1989-11-11', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000022e0efd855180d0022', 'name' => 'Szűcs Erzsébet', 'username' => 'szucserzsebet', 'email' => 'szucs.erzsebet@gmail.com', 'password' => 'Erzsi!678', 'birth_date' => '1987-04-05', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000023e0efd855180d0023', 'name' => 'Dávid Mátyás', 'username' => 'davidmatyas', 'email' => 'david.matyas@gmail.com', 'password' => 'Matyas123!', 'birth_date' => '2001-01-28', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000024e0efd855180d0024', 'name' => 'Fekete Kinga', 'username' => 'feketekinga', 'email' => 'fekete.kinga@gmail.com', 'password' => 'Kinga!234', 'birth_date' => '1995-07-16', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000025e0efd855180d0025', 'name' => 'Orosz Szilárd', 'username' => 'oroszszilard', 'email' => 'orosz.szilard@gmail.com', 'password' => 'Szilard2019!', 'birth_date' => '1983-09-09', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000026e0efd855180d0026', 'name' => 'Vásárhelyi Tímea', 'username' => 'vasarhelyitimea', 'email' => 'vasarhelyi.timea@gmail.com', 'password' => 'Timea!890', 'birth_date' => '1993-05-21', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000027e0efd855180d0027', 'name' => 'Bárdos Mihály', 'username' => 'bardosmihaly', 'email' => 'bardos.mihaly@gmail.com', 'password' => 'Mihaly123!', 'birth_date' => '1991-12-02', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000028e0efd855180d0028', 'name' => 'Ladányi Noémi', 'username' => 'ladanyinoemi', 'email' => 'ladanyi.noemi@gmail.com', 'password' => 'Noemi!567', 'birth_date' => '1998-03-31', 'role' => UserRoleEnum::USER],
            ['_id' => '6a000029e0efd855180d0029', 'name' => 'Almási Zoltán', 'username' => 'almasizoltan', 'email' => 'almasi.zoltan@gmail.com', 'password' => 'Zoltan2018!', 'birth_date' => '1980-06-14', 'role' => UserRoleEnum::USER],
            ['_id' => '6a00002ae0efd855180d002a', 'name' => 'Csíki Beáta', 'username' => 'csikibeata', 'email' => 'csiki.beata@gmail.com', 'password' => 'Beata!321', 'birth_date' => '1997-10-27', 'role' => UserRoleEnum::USER],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['_id' => new ObjectId($user['_id'])],
                [
                    'name' => $user['name'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'password' => Hash::make($user['password']),
                    'birth_date' => $user['birth_date'],
                    'role' => $user['role'],
                ]
            );
        }
    }
}
