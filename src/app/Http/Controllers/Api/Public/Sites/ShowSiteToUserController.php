<?php

namespace App\Http\Controllers\Api\Public\Sites;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserSiteResouce;
use App\Models\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowSiteToUserController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        if ($user && ($user->id == $request->id || $user->isSuperAdmin())) {
            return UserSiteResouce::collection(Site::where('user_id', $request->id)->get());
        }
        return new JsonResponse(['message' => 'Accès interdit'], 403);
    }

    public function show(Request $request) {
        $user = Auth::user();
        if ($user && ($user->id == $request->id || $user->isSuperAdmin())) {
            return UserSiteResouce::collection(collect([Site::find($request->site)]));

        }
        return new JsonResponse(['message' => 'Accès interdit'], 403);
    }
}
