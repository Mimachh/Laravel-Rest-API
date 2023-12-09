<?php

namespace App\Http\Controllers\Api\Public\Sites;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteSiteController extends Controller
{
    public function softDelete(Request $request) {
        $siteId = $request->site;
        $siteToDelete = Site::find($siteId);
        $userId = $request->user;
        $user = Auth::user();

        // $user->can('forceDelete', $siteToDelete);
        $this->authorize('forceDelete', $siteToDelete);

        // return response()->json(['message' => $siteToDelete, 'user' => $user], 404);

        if (!$siteToDelete) {
            return response()->json(['message' => 'Aucun site trouvé'], 404);
        }
        $siteToDelete->delete(); // Effectue une suppression logique en définissant deleted_at
        return response()->json(['message' => 'Site supprimé avec succès']);
    }

    public function forceDelete(Request $request) {
        $siteId = $request->site;
        $userId = $request->user;

        $siteToDelete = Site::find($siteId);
    }
}
