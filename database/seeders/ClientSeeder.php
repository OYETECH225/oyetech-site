<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        // Clients réels uniquement. Le logo s'ajoute dans l'admin ; seuls les clients
        // avec logo apparaissent dans « Ils nous font confiance » (2 minimum).
        $clients = [
            ['name' => 'CFTS West Africa', 'order' => 1],
        ];

        foreach ($clients as $client) {
            Client::updateOrCreate(['name' => $client['name']], $client);
        }
    }
}
