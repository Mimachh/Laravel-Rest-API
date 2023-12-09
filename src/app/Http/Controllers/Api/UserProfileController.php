<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\CloudinaryServiceController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AvatarUserRequest;
use App\Http\Requests\Api\UpdateUserProfileRequest;
use App\Models\User;

use Illuminate\Support\Facades\Auth;


class UserProfileController extends Controller
{

    public function update(UpdateUserProfileRequest $request, $userId)
    {
        $user = Auth::user();
        
        $this->authorize('update', ['App\Models\User', $userId]);

      
        // if ($userId != $user->id && !$user->isAdmin()) {
        //     return response()->json(["UPDATE_ERROR_FORBIDDEN"], 403);
        // }

        $userToUpdate = User::find($userId);
        $userToUpdate->update([
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
        ]);
        return response()->json(['message' => 'Profil mis à jour avec succès']);
    }

    public function avatar(AvatarUserRequest $request, $userId) 
    {
        
        $this->authorize('update', ['App\Models\User', $userId]);
        $userToUpdate = User::find($userId);

        
        if($userToUpdate->avatar) {
            $deleteCloudinaryController = new CloudinaryServiceController();
            $deleteCloudinaryController->deleteFromCloudinary($userToUpdate->avatar);
        }

        $userToUpdate->update([
            "avatar" => $request->input('avatar'),
        ]);
        return response()->json(['message' => 'Avatar enregistré']);
    }

    public function avatarDelete($userId)
    {
        $this->authorize('update', ['App\Models\User', $userId]);

        $user = User::find($userId);
        $imageUrl = $user->avatar;

        $deleteCloudinaryController = new CloudinaryServiceController();
        $deleteCloudinaryController->deleteFromCloudinary($imageUrl);

        $user->avatar = null; 
        $user->save();
        
        return response()->json(['message' => 'Image deleted']);
    }
    
}
