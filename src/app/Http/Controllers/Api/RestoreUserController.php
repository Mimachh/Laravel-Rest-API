<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RestoreUserController extends Controller
{
    public function restoreUser(Request $request) 
    {
        $userId = $request->id;

        $this->authorize('restoreUser', ['App\Models\User', $userId]);

        $userToRestore = User::withTrashed()->where('id', $userId)->first();

        if (!$userToRestore) {
            return response()->json(['message' => 'Utilisateur introuvable'], 404);
        }

        $userToRestore->restore();
        return response()->json(['message' => 'Utilisateur restauré avec succès']);
    }
}
