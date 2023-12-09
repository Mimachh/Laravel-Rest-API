<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SoftDeleteUserController extends Controller
{
    public function softDelete(Request $request) 
    {
        $userId = $request->id;
        // $this->authorize('softDelete', ['App\Models\User', $userId]);
        
        $userToDelete = User::find($userId);

        if (!$userToDelete) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        $userToDelete->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }
}
