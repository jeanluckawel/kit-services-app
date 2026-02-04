<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::create([
            'name' => 'KAMOA COPPER SA',
            'id_nat' => '05-B0500-N37233JJ',
            'rccm' => '14-B-1683',
            'nif' => 'A0901048A',
            'province' => 'Lualaba',
            'ville' => 'Kolwezi',
            'commune' => 'Manika',
            'quartier' => 'Joli-Site',
            'avenue' => 'Route Likasi',
            'numero' => '2404',
            'telephone' => '00243 977 333 977',
            'email' => 'contact@kamoacopper.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
