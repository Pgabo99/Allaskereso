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
