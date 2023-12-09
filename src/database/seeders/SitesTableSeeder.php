<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;


class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = 'Site internet';
        $url = 'http://localhost';
        $userName = 'NomUtilisateur'; // Remplacez par le nom de l'utilisateur approprié
    
        $key = 'votre_cle_secrete'; // Remplacez par votre clé secrète

        
        $payload = [
            'name' => $name,
            'url' => $url,
            'userName' => $userName,
            'exp' => time() + 3600,
        ];
    
        $algorithm = "HS256";

        // Génération du JWT en utilisant les trois arguments
        $token = JWT::encode($payload, $key, $algorithm);

        $lettresPersonnalisees = "Mm_"; // Remplacez par vos lettres personnalisées
        $token = $lettresPersonnalisees . $token;

        DB::table('sites')->insert([
        [
            'name' => 'Site internet',
            'url' => 'http://localhost',
            'token' => $token,
            'user_id' => 1
        ],
        ]);
    }
}
