<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ContratSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contrats')->insert([
            [
                'id' => 4,
                'user_id' => 2,
                'demandeur_id' => 4,
                'type' => 'randonnee',
                'proprietaire_id' => 4,
                'navire_id' => 4,
                'gardien_id' => 4,
                'mouvements' => json_encode([
                    "num_titre_com" => "35830459",
                    "equipage" => "9",
                    "passagers" => "5",
                    "total_personnes" => "14",
                    "majoration_stationnement" => "50"
                ]),
                'date_debut' => '2025-06-11',
                'date_fin' => '2025-07-02',
                'signe_par' => 'demandeur',
                'accepte_le' => '2025-07-02',
                'date_signature' => '2025-06-10',
                'created_at' => '2025-06-10 13:46:41',
                'updated_at' => '2025-06-10 13:46:41',
            ],
            [
                'id' => 5,
                'user_id' => 2,
                'demandeur_id' => 5,
                'type' => 'accostage',
                'proprietaire_id' => 5,
                'navire_id' => 5,
                'gardien_id' => 5,
                'mouvements' => json_encode([
                    "num_abonn" => "69456094",
                    "ponton" => "BOUREGREG",
                    "num_poste" => "N34895",
                    "autres_prestations" => ["Gardiennage", "Guidage", "Electricité"],
                    "com_assurance" => "SAHAM",
                    "num_police" => "NP54943",
                    "echeance" => "Tj4330"
                ]),
                'date_debut' => '2025-06-10',
                'date_fin' => '2025-06-26',
                'signe_par' => 'M. Admin',
                'accepte_le' => '2025-06-25',
                'date_signature' => '2025-06-10',
                'created_at' => '2025-06-10 13:59:33',
                'updated_at' => '2025-06-10 13:59:33',

            ],
        ]);
        
    }
}