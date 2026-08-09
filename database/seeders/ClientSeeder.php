<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'CFTS West Africa', 'order' => 1],
            ['name' => 'Groupe agro-industriel ivoirien', 'order' => 2],
            ['name' => 'Fintech régionale', 'order' => 3],
            ['name' => 'Distributeur régional', 'order' => 4],
            ['name' => 'Agence de gestion immobilière', 'order' => 5],
        ];

        foreach ($clients as $client) {
            Client::updateOrCreate(['name' => $client['name']], $client);
        }
    }
}
