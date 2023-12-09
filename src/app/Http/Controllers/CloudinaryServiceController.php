<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CloudinaryServiceController extends Controller
{
    public function deleteFromCloudinary($imageUrl) {


        $publicId = $this->extractPublicId($imageUrl);
        
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');
        $timestamp = time();
        $paramsToSign = "public_id=$publicId&timestamp=$timestamp";
        $signature = sha1($paramsToSign . $apiSecret);
    
        $response = Http::delete("https://api.cloudinary.com/v1_1/$cloudName/image/destroy", [
            'public_id' => $publicId, // Incluez "avatar" dans le public ID
            'signature' => $signature,
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
        ]);
    }

    private function extractPublicId($imageUrl)
    {
        $parts = explode('/', $imageUrl);
        // Vérifiez si l'ID public est la dernière partie de l'URL
        $publicId = end($parts);
        // Supprimez toute extension après l'ID public
        $publicId = preg_replace('/\..+$/', '', $publicId);

        return $publicId;
    }
}
