<?php

namespace App\Http\Controllers\Api\Public\Sites;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Public\Sites\CreateSiteRequest;
use Firebase\JWT\JWT;

class CreateSiteController extends Controller
{
    public function store(CreateSiteRequest $request) {
        $user = Auth::user();

        // Fonction pour créer le token 
        $name = $request->name;
        $url = $request->url;
        $userId = $user->id;
        // $token = "coucou";
        $token = $this->createToken($name, $url, $userId);

        Site::create([
            "name" => $request->name,
            "url" => $request->url,
            "token" => $token,
            "monthly_mail" => 0,
            "total_mail" => 0,
            "user_id" => $user->id
        ]);
        return response()->json(['message' => 'Site crée avec succès']);
    }

    private function createToken($name, $url, $userId) {
        
        $secretKey = env('APP_SECRET_KEY');
        $timestamp = time();
        
        $payload = [
            'name' => $name,
            'url' => $url,
            'userId' => $userId,
            'timestamp' => $timestamp,
        ];

        $algorithm = "HS256";
        $token = JWT::encode($payload, $secretKey, $algorithm);

        $lettresPersonnalisees = "Mm_"; // Remplacez par vos lettres personnalisées
        $token = $lettresPersonnalisees . $token;

        return $token;
    }
}